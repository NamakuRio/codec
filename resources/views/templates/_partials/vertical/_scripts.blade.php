<!-- Vendor js -->
<script src="@asset('assets/js/vendor-vertical.min.js')"></script>

@yield('script')
<!-- Sweet Alert -->
<script src="@asset('assets/libs/sweetalert/sweetalert2.all.min.js')"></script>
<!-- Modal-Effect -->
<script src="@asset('assets/libs/custombox/custombox.min.js')"></script>

<!-- App js -->
<script src="@asset('assets/js/app-vertical.min.js')"></script>

<script>
    var url = "{{ url('/') }}";

    $(document).on("DOMContentLoaded", function () {
        lazyLoad();
    });

    $(document).on("DOMNodeInserted", function () {
        lazyLoad();
    });

    function notification(icon, title, position = "top-end", showConfirmButton = false, timer = 3000, timerProgressBar = true)
    {
        const Toast = Swal.mixin({
            toast: true,
            position: position,
            showConfirmButton: showConfirmButton,
            timer: timer,
            timerProgressBar: timerProgressBar,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: icon,
            title: title
        });
    }

    function swalNotification(status, message)
    {
        swal(message, {
            icon: status,
        });
    }

    var timeOut = null;

    function alert(location, status, message, time = 0)
    {
        var alerts = $(location).html(`
        <div class="alert alert-`+status+` mb-2" role="alert">
            `+message+`
        </div>
        `);

        if(time != 0){
            clearTimeout(timeOut);
            timeOut = setTimeout(() => {
                alerts.empty();
            }, time);

        }

    }

    function openModal(target, effect = 'fadein', focus = null)
    {
        var modal = new Custombox.modal({
            content: {
                effect: effect,
                target: target,
            }
        });

        modal.open();

        if(focus != null){
            focusable(focus);
        }
    }

    function focusable(target)
    {
        setTimeout(() => {
            $(target).focus();
        }, 1);
    }

    function lazyLoad()
    {
        var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

        if("IntersectionObserver" in window) {
            let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if(entry.isIntersecting){
                        let lazyImage = entry.target;
                        lazyImage.src = lazyImage.dataset.original;
                        lazyImage.classList.remove("lazy");
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });

            lazyImages.forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        } else {
            console.log('gagal memuat gambar');
        }
    }
</script>

@yield('script-bottom')
