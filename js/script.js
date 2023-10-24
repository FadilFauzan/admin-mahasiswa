// ambil elemen yang dibutuhkan
var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('cari');
var container = document.getElementById('container');

// tambahkan event pada keyword
keyword.addEventListener('keyup', function(){
    
    // object ajax
    var xhr = new XMLHttpRequest();

    // cek kesiapan ajax
    xhr.onreadystatechange = function(){
        if (xhr.readyState == 4 && xhr.status == 200){
            // console.log(xhr.responseText);
            container.innerHTML = xhr.responseText;
        } else {
            console.log("error")
        }
    }

    // eksekusi ajax
    xhr.open('GET', 'ajax/ajaxMahasiswa.php?key=' + keyword.value, true); // asinkronus
    xhr.send();

});