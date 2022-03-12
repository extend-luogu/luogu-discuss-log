<link rel="shortcut icon" type="image/x-icon" href="//www.luogu.com.cn/favicon.ico" media="screen" />
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="/dist/sweetalert2@10.js"></script>
<link rel="stylesheet" href="/dist/katex.min.css">
<script defer src="/dist/katex.min.js"></script>
<script defer src="/dist/auto-render.min.js"></script>
<link href="/dist/lghljs.css" rel="stylesheet">
<link href="/dist/main.css?ver=20211119" rel="stylesheet">
<script src="/dist/hljs.js"></script>
<script src="https://cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});
</script>