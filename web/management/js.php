<script src="<?=rootURL();?>bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=rootURL();?>sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script>
    const tooltipTriggerList = document.querySelectorAll('.btn-tooltip')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    const inputContainers = document.querySelectorAll('body');

    inputContainers.forEach((container) => {
        const input = container.querySelector('.image-input');
        const preview = container.querySelector('.image-preview');

        if (input && preview) {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };

                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>