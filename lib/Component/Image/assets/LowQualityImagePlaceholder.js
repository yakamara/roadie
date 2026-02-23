document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('img[data-lqip]').forEach(img => {
        if (img.complete) {
            img.setAttribute('data-loaded', 'true');
        } else {
            img.addEventListener('load', () => {
                img.setAttribute('data-loaded', 'true');
            });
        }
    });
});