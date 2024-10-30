function IsEmpty() {
    var a = document.forms["Form"]["LoginForm[username]"].value;
    var b = document.forms["Form"]["LoginForm[password]"].value;
    if (a == null || a == "", b == null || b == "") {
        //alert("Silahkan isi username dan/atau password Anda.");
        swal({
            title: "Hai!",
            text: "Mohon lengkapi isi username dan/atau password Anda.",
            icon: "error",
            button: "OK",
            dangerMode: false,
        });
        return false;
    }
}