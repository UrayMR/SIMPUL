@props([
    'id', // id unik untuk komponen
    'label', // label dropdown
    'name', // nama input hidden
    'options' => [], // array opsi
    'placeholder' => null, // placeholder tombol
    'disabled' => false, // disable dropdown
    'dropdownClass' => '', // custom class
    'buttonClass' => '', // custom class
    'ulClass' => '', // custom class
    'selected' => null, // value terpilih
    'searchable' => true, // dropdown searchable
    'required' => false, // required input
])
<div class="dropdown {{ $dropdownClass }}">
    <button id="btn-{{ $id }}"
        class="btn btn-outline-secondary form-control text-start dropdown-toggle {{ $buttonClass }}"
        data-bs-toggle="dropdown" @if ($disabled) disabled @endif>
        {{ $selected && isset($options[$selected]) ? $options[$selected] : $placeholder ?? 'Pilih ' . $label }}
    </button>
    <ul class="dropdown-menu w-100 {{ $ulClass }}" id="dropdown-{{ $id }}">
        @if ($searchable)
            <li class="px-2 py-1">
                <input type="text" class="form-control form-control-sm" placeholder="Cari {{ strtolower($label) }}..."
                    id="search-{{ $id }}">
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
        @endif

        <div id="list-{{ $id }}" style="max-height:150px; overflow-y:auto;">

            @forelse($options as $key => $value)
                <li>
                    <a class="dropdown-item py-1" data-value="{{ $key }}">
                        {{ $value }}
                    </a>
                </li>
            @empty
                <li><span class="dropdown-item-text text-muted">Tidak ada data</span></li>
            @endforelse
        </div>
    </ul>
    <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $selected }}"
        @if ($required) required @endif>
    <div id="error-{{ $id }}" class="invalid-feedback" style="display:none;">
        {{ $label }} wajib dipilih.
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        function attachEventItems() {
            document.querySelectorAll("#list-{{ $id }} .dropdown-item").forEach(item => {
                item.addEventListener("click", function() {
                    const value = this.getAttribute("data-value");

                    const hiddenInput = document.getElementById("{{ $id }}");
                    const button = document.getElementById("btn-{{ $id }}");

                    hiddenInput.value = value;

                    button.textContent = this.textContent;

                    hiddenInput.dispatchEvent(new Event('change'));
                });
            });
        }

        attachEventItems(); // panggil awal

        // Search
        @if ($searchable)
            const searchInput = document.getElementById("search-{{ $id }}");

            searchInput.addEventListener("input", function() {
                const keyword = this.value.toLowerCase();

                // ambil ulang karena list bisa berubah saat AJAX
                const items = document.querySelectorAll("#list-{{ $id }} .dropdown-item");

                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(keyword) ? "" : "none";
                });
            });
        @endif

        // Validasi required saat submit form
        if ({{ $required ? 'true' : 'false' }}) {
            const form = document.getElementById("{{ $id }}").closest('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const hiddenInput = document.getElementById("{{ $id }}");
                    const button = document.getElementById("btn-{{ $id }}");
                    const errorDiv = document.getElementById("error-{{ $id }}");
                    if (!hiddenInput.value.trim()) {
                        button.classList.add('is-invalid');
                        errorDiv.style.display = '';
                        e.preventDefault();
                    } else {
                        button.classList.remove('is-invalid');
                        errorDiv.style.display = 'none';
                    }
                });

                // Hilangkan error saat memilih
                document.querySelectorAll("#list-{{ $id }} .dropdown-item").forEach(item => {
                    item.addEventListener("click", function() {
                        const button = document.getElementById("btn-{{ $id }}");
                        const errorDiv = document.getElementById("error-{{ $id }}");
                        button.classList.remove('is-invalid');
                        errorDiv.style.display = 'none';
                    });
                });
            }
        }
    });
</script>
