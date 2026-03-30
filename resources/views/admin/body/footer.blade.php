<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div
            class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , réalisé par
                <a href="{{ route('client.index') }}"
                    target="_blank"
                    class="footer-link text-primary fw-medium">
                    ABS TECHNOLOGIE Group
                </a>
            </div>
            {{-- <div class="d-none d-lg-inline-block">

                <a href="#" class="footer-link me-4"
                    target="_blank">
                    License
                </a>

                <a  href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4">
                    Documentation
                </a>

            </div> --}}
        </div>
    </div>
</footer>
