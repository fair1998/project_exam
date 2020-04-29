function del() {
    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form
    Swal.fire({
        title: 'คุณยืนยันที่จะลบไหม ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.value) {
            form.submit();
        }
    })
}
