<!-- Core Scripts - Include with every page -->
<script src="{{ asset('back/js/jquery-1.10.2.js') }}"></script>

<script src="{{ asset('back/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('back/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>


<!-- SB Admin Scripts - Include with every page -->
<script src="{{ asset('back/js/sb-admin.js') }}"></script>

<!-- Page-Level Plugin Scripts - Tables -->
<script src="{{ asset('back/js/plugins/dataTables/jquery.dataTables.js') }}"></script>

<script src="{{ asset('back/js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>

<script src="{{ asset('back/vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/dropzone/dropzone.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const Toast = Swal.mixin({
        toast: true,
        animation: true,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
    });

    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });

    function confirmToast(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, comfirm it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = url;
            }
        });
    }

    function deleteToast(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#deleteForm_${id}`).submit();
            }
        });
    }
</script>
