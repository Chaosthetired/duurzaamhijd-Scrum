(() => {
    function q(sel, root = document) { return root.querySelector(sel); }

    function getApiUrl() {
        const table = q('#pending-table');
        return table?.dataset.api || 'api/company_moderation.php';
    }

    function toast(msg) {
        const el = document.createElement('div');
        el.className = 'alert success';
        el.textContent = msg;
        el.style.position = 'fixed';
        el.style.right = '1rem';
        el.style.bottom = '1rem';
        el.style.zIndex = '9999';
        el.style.maxWidth = '60ch';
        el.style.padding = '.6rem .9rem';
        el.style.borderRadius = '.5rem';
        document.body.appendChild(el);
        setTimeout(() => el.remove(), 2500);
    }

    async function postJSON(url, payload) {
        const res = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(payload),
            credentials: 'same-origin'
        });

        const ct = res.headers.get('content-type') || '';
        const text = await res.text();

        let data = null;
        if (ct.includes('application/json')) {
            try { data = JSON.parse(text); } catch { }
        }

        if (res.redirected || /login\.php/i.test(res.url) || /<html/i.test(text)) {
            throw new Error('Niet ingelogd / naar login omgeleid');
        }

        if (data && data.ok === false) {
            throw new Error(data.error || 'Server gaf een fout terug');
        }

        if (res.ok && !data) {
            throw new Error('Server gaf geen geldige JSON terug: ' + text.slice(0, 200));
        }

        if (!res.ok) {
            throw new Error(`HTTP ${res.status} ${res.statusText || ''}`.trim());
        }

        return data;
    }

    function handleEmptyTable(table) {
        if (!table?.tBodies?.[0]?.rows?.length) {
            const existing = q('.pending-empty');
            if (existing) { existing.textContent = 'Er zijn momenteel geen bedrijven in afwachting.'; return; }
            const p = document.createElement('p');
            p.className = 'pending-empty';
            p.textContent = 'Er zijn momenteel geen bedrijven in afwachting.';
            table.parentNode.insertBefore(p, table);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const table = q('#pending-table');
        if (!table) return;

        const API = getApiUrl();

        table.addEventListener('click', async (e) => {
            const btn = e.target.closest('.act[data-action]');
            if (!btn) return;

            const tr = btn.closest('tr');
            const id = tr?.dataset.companyId;
            const action = btn.dataset.action; // "accepteren" | "afwijzen"
            if (!id) return;

            if (action === 'afwijzen' && !confirm('Weet je zeker dat je dit bedrijf wil afwijzen?')) {
                return;
            }

            btn.disabled = true;

            try {
                const data = await postJSON(API, { company_id: id, action });
                tr.remove();
                toast((data.new_status === 'accepted' ? 'Geaccepteerd' : 'Afgewezen') + ' #' + id);
                handleEmptyTable(table);
            } catch (err) {
                alert('Fout: ' + (err?.message || err));
                btn.disabled = false;
            }
        });
    });
})();
