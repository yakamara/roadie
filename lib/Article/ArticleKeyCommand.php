<?php

namespace Yakamara\Roadie\Article;

use BackedEnum;
use rex_article;
use rex_console_command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function count;

class ArticleKeyCommand extends rex_console_command
{
    protected function configure(): void
    {
        $this
            ->setDescription('Artikel-Keys verwalten (list | set <key> <id> | remove <key>)')
            ->addArgument('action', InputArgument::REQUIRED, 'Aktion: list, set, remove')
            ->addArgument('key', InputArgument::OPTIONAL, 'Artikel-Key (z. B. imprint)')
            ->addArgument('id', InputArgument::OPTIONAL, 'Artikel-ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return match ($input->getArgument('action')) {
            'list' => $this->listKeys($output),
            'set' => $this->setKey($input, $output),
            'remove' => $this->removeKey($input, $output),
            default => $this->unknownAction($input->getArgument('action'), $output),
        };
    }

    private function listKeys(OutputInterface $output): int
    {
        $io = $this->getStyle(new ArrayInput([]), $output);

        $registry = ArticleKeyRegistry::all();
        $multipleNamespaces = count($registry) > 1;

        $rows = [];
        foreach ($registry as $enumClass => $namespace) {
            foreach ($enumClass::cases() as $key) {
                $article = ArticleResolver::get($key);
                $row = [
                    $key->value,
                    $article ? $article->getName() : '<comment>–</comment>',
                    $article ? (string) $article->getId() : '<comment>nicht gesetzt</comment>',
                ];
                if ($multipleNamespaces) {
                    $row[] = $namespace;
                }
                $rows[] = $row;
            }
        }

        $headers = ['Key', 'Artikel', 'ID'];
        if ($multipleNamespaces) {
            $headers[] = 'Namespace';
        }

        $io->table($headers, $rows);

        return self::SUCCESS;
    }

    private function setKey(InputInterface $input, OutputInterface $output): int
    {
        $keyValue = $input->getArgument('key');
        $id = (int) $input->getArgument('id');

        $key = $this->resolveCase((string) $keyValue, $output);
        if (!$key) {
            return self::FAILURE;
        }

        if ($id <= 0) {
            $output->writeln('<error>Ungültige Artikel-ID: ' . $input->getArgument('id') . '</error>');
            return self::FAILURE;
        }

        $article = rex_article::get($id);
        if (!$article) {
            $output->writeln('<error>Artikel mit ID ' . $id . ' nicht gefunden.</error>');
            return self::FAILURE;
        }

        ArticleResolver::set($key, $id);
        $output->writeln('<info>✓ ' . $key->value . ' → ' . $article->getName() . ' [' . $id . ']</info>');

        return self::SUCCESS;
    }

    private function removeKey(InputInterface $input, OutputInterface $output): int
    {
        $key = $this->resolveCase((string) $input->getArgument('key'), $output);
        if (!$key) {
            return self::FAILURE;
        }

        ArticleResolver::remove($key);
        $output->writeln('<info>✓ ' . $key->value . ' entfernt.</info>');

        return self::SUCCESS;
    }

    /** Finds a BackedEnum case across all registered enums. Reports error if not found or ambiguous. */
    private function resolveCase(string $keyValue, OutputInterface $output): ?BackedEnum
    {
        $found = [];
        foreach (ArticleKeyRegistry::all() as $enumClass => $namespace) {
            $case = $enumClass::tryFrom($keyValue);
            if (null !== $case) {
                $found[] = ['case' => $case, 'namespace' => $namespace];
            }
        }

        if (0 === count($found)) {
            $all = [];
            foreach (ArticleKeyRegistry::all() as $enumClass => $namespace) {
                foreach ($enumClass::cases() as $c) {
                    $all[] = $c->value;
                }
            }
            $output->writeln('<error>Unbekannter Key: ' . $keyValue . '</error>');
            $output->writeln('Gültige Keys: ' . implode(', ', $all));
            return null;
        }

        if (count($found) > 1) {
            $namespaces = implode(', ', array_column($found, 'namespace'));
            $output->writeln('<error>Key „' . $keyValue . '" ist in mehreren Namespaces registriert: ' . $namespaces . '</error>');
            return null;
        }

        return $found[0]['case'];
    }

    private function unknownAction(string $action, OutputInterface $output): int
    {
        $output->writeln('<error>Unbekannte Aktion: ' . $action . '</error>');
        $output->writeln('Verfügbare Aktionen: list, set, remove');

        return self::FAILURE;
    }
}
