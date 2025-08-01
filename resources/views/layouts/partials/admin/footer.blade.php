<div class="overlay btn-toggle"></div>
    
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>

    <script src="{{ asset('admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/sweetalert2@11.js') }}"></script>

    <script src="{{ asset('admin/js/web-components.min.js') }}?cw=76"></script>
    <script src="{{ asset('admin/js/helpers.min.js') }}?cw=76"></script>
    <script src="{{ asset('admin/js/custom.min.js') }}?cw=76"></script>
    @stack('script')
    <script>
        window.onload = function() {
            document.querySelector('.page-loader').classList.add('hidden');
            document.body.classList.remove('loading');
        }

    </script>
</body>

</html>
