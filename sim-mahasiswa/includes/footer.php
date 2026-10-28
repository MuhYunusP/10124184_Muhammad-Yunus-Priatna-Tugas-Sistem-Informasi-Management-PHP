</main>

<footer class="footer">
    <p>&copy; <?= date('Y') ?> — <?= e(t('app_title')) ?> | <?= e(t('footer')) ?></p>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. KUNCI UNIK (Membedakan draft antara halaman Create, Edit ID 1, Edit ID 2, dll)
    const params = new URLSearchParams(window.location.search);
    params.delete('lang'); // Buang parameter lang agar draft tidak hilang saat ganti bahasa
    const searchStr = params.toString();
    const formKey = 'form_draft_' + window.location.pathname + (searchStr ? '?' + searchStr : '');

    // 2. KEMBALIKAN DATA SAAT HALAMAN DIMUAT ULANG
    const savedData = sessionStorage.getItem(formKey);
    if (savedData) {
        try {
            const data = JSON.parse(savedData);
            const form = document.querySelector('form.card');
            if (form) {
                for (const [name, value] of Object.entries(data)) {
                    const input = form.querySelector(`[name="${name}"]`);
                    if (input) {
                        input.value = value;
                    }
                }
            }
        } catch (e) {
            console.error('Gagal memuat data form', e);
        }
    }

    // 3. SIMPAN DATA SETIAP KALI ADA KETIKAN
    const form = document.querySelector('form.card');
    if (form) {
        const inputs = form.querySelectorAll('input:not([type="hidden"]), textarea, select');
        
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                const data = {};
                let hasData = false;
                
                inputs.forEach(inp => {
                    if (inp.name) {
                        data[inp.name] = inp.value;
                        if (inp.value.trim() !== '') hasData = true;
                    }
                });

                if (hasData) {
                    sessionStorage.setItem(formKey, JSON.stringify(data));
                } else {
                    sessionStorage.removeItem(formKey);
                }
            });
        });

        // 4. HAPUS DRAFT JIKA FORM DI-SUBMIT (DISIMPAN) ATAU DIBATALKAN
        form.addEventListener('submit', function() {
            sessionStorage.removeItem(formKey);
        });
        
        const cancelBtn = form.querySelector('a.btn-secondary');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                sessionStorage.removeItem(formKey);
            });
        }
    }
});
</script>

</body>
</html>