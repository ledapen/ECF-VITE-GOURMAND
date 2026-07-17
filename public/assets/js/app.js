document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('menuFilters');
    const container = document.getElementById('menusContainer');

    if (form && container) {
        form.addEventListener('change', async () => {
            const params = new URLSearchParams(new FormData(form));
            const response = await fetch('/api/menus?' + params.toString());
            const menus = await response.json();

            container.innerHTML = '';

            if (menus.length === 0) {
                container.innerHTML = '<p>Aucun menu ne correspond aux filtres.</p>';
                return;
            }

            menus.forEach(menu => {
                const article = document.createElement('article');
                article.className = 'col-md-4 mb-4';
                article.innerHTML = `
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="h5">${escapeHtml(menu.titre)}</h2>
                            <p>${escapeHtml(menu.description)}</p>
                            <p><strong>${Number(menu.prix_minimum).toFixed(2)} €</strong>
                            pour ${menu.nb_personnes_min} personnes minimum</p>
                            <a class="btn btn-outline-success" href="/menu?id=${menu.id_menu}">Voir le détail</a>
                        </div>
                    </div>`;
                container.appendChild(article);
            });
        });
    }
});

function escapeHtml(value) {
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}
