# Sistem Deteksi Wajah dan Suhu Untuk Presensi dan Pengecekan Suhu Tubuh Berbasis IoT

<p align="center">
  <img width="500" alt="logo" src="Docs/1.png"/>
</p>

<p align="center">
  <img width="500" alt="logo" src="Docs/5.png"/>
</p>

<p align="center">
  <img width="500" alt="logo" src="Docs/6.png"/>
</p>

![](https://img.shields.io/badge/Captone-Design-blue)
![](https://img.shields.io/badge/python-v3.1.1+-success.svg)
![](https://img.shields.io/badge/Computer-Engineering-success.svg)
![](https://img.shields.io/badge/Face-Recognition-success.svg)

Sistem Deteksi Wajah dan Suhu untuk Presensi dan Pengecekan Suhu Tubuh Berbasis IoT adalah sebuah alat yang menggabungkan teknologi _Internet of Things_ (IoT) dengan deteksi wajah dan pengukuran suhu tubuh. Alat ini menggunakan _hardware_ seperti _webcam_ untuk mendeteksi wajah dan sensor suhu AMG8833 untuk mengukur suhu tubuh. Raspberry Pi 4 Model B berperan sebagai mikrokontroller utama yang menjalankan sistem, dengan sistem operasi Raspbian sebagai platformnya.

Dalam melakukan deteksi wajah, alat ini memanfaatkan algoritma _Local Binary Pattern Histogram_ dan _Haar Cascade Classifier_, serta didukung oleh antarmuka grafis (GUI) yang intuitif. Pengguna dapat mengeluarkan perintah deteksi wajah dan mengambil sampel wajah dengan mudah melalui GUI ini.

Alat ini juga memiliki kemampuan untuk mencocokkan wajah yang terdeteksi dengan data wajah yang sudah ada dalam _database_. Selain itu, sistem ini memiliki fitur penting, yaitu jika suhu tubuh pengguna lebih dari 38 derajat Celsius, presensi tidak akan berhasil, yang merupakan langkah proaktif dalam menjaga kesehatan pengguna.

Data presensi yang berhasil dikumpulkan akan dikirimkan ke sebuah _website_ yang telah di-_hosting_. Pengguna dapat dengan mudah mengunduh hasil rekapan presensi dalam format file Excel melalui _website hosting_. Selain itu, notifikasi presensi juga akan otomatis dikirimkan ke telegram pengguna melalui bot Telegram.

Sistem ini berhasil mengintegrasikan semua komponen, termasuk _website hosting_, _database server online_, dan bot Telegram. Data presensi akan tersimpan dengan aman pada _database server online_ dan dapat diakses melalui _website hosting_ dan melalui bot Telegram.

Selama proses pengembangan, sampel wajah sebanyak 25 foto untuk satu individu disimpan dalam _database_ sebagai bahan referensi untuk pencocokkan wajah saat algoritma deteksi wajah berjalan.

Alat ini juga memanfaatkan berbagai teknologi dan perangkat lunak, termasuk Python dengan _library_ seperti OpenCV, Tkinter, dan NumPy untuk implementasi deteksi wajah dan antarmuka pengguna.

Penyimpanan data menggunakan _database_ PHPMyAdmin MySQL yang di-_hosting_ pada _server online_ yang disediakan oleh layanan _hosting_ yang digunakan. Pembuatan _Website_ menggunakan bahasa pemrograman PHP dengan dukungan dari _framework_ Laravel dan Bootstrap untuk memastikan antarmuka web yang responsif dan ramah pengguna.

Sistem Deteksi Wajah dan Suhu ini menggabungkan teknologi canggih untuk memberikan solusi presensi yang efisien, aman, dan proaktif dalam menjaga kesehatan pengguna.

## Flowchart Sistem

<p align="center">
  <img width="500" alt="logo" src="Docs/2.png"/>
</p>

<p align="center">
    <b>Gambar 1</b> Flowchart Sistem
</p>

Pada Gambar 1, merupakan gambaran umum yang diperoleh meliputi blok diagram. Terdiri dari beberapa komponen yang digunakan pada alat yang akan dirancang, sehingga komponen satu dengan lainnya terhubung, menjadikan sebuah _prototype_. Sistem yang akan dibuat memiliki beberapa komponen yang harus disediakan diantaranya sensor AMG8833 dan _webcam_ sebagai _input_. Raspberry Pi 4 Model B sebagai mikrokontroler yang 
terhubung pada monitor sebagai tempat melakukan pemrograman data, terhubung pada catu 
daya. _Speaker_ dan tampilan data pada monitor dijadikan _output_ hasil data.

_Speaker_ memberikan suara peringatan ketika suhu tidak normal. Bot telegram dan juga 
_website admin dashboard_ ( http://presensiku.xyz/cd ) digunakan sebagai wadah untuk 
menampilkan data hasil presensi. Bot Telegram berupa notifikasi yang menampilkan data 
nama dan waktu, _Website_ sebagai wadah agar pengguna bisa mengakses beberapa fitur 
terutama untuk mengunduh rekapan data hasil presensi yang berupa file excel.

Sistem pendeteksian wajah ini diprogram menggunakan Bahasa Python, dibantu dengan 
beberapa _library_ diantaranya OpenCV, NumPy, Tkinter, dll. Program ini juga mengaplikasikan 
beberapa algoritma diantaranya _Haar Cascade Algorithm_ dan _Local Binary Pattern Histogram_
(LBPH) Algorithm.

<p align="center">
  <img width="500" alt="logo" src="Docs/3.png"/>
</p>

<p align="center">
    <b>Gambar 2</b> Desain Perangkat Keras
</p>

<p align="center">
  <img width="500" alt="logo" src="Docs/4.png"/>
</p>

<p align="center">
    <b>Gambar 3</b> Flowchart Presensi
</p>

## Website dan Bot Telegram

Untuk halaman website dapat diakses melalui alamat berikut : http://presensiku.xyz/cd

<p align="center">
  <img width="500" alt="logo" src="Docs/7.png"/>
</p>

<p align="center">
    <b>Gambar 4</b> Tampilan Menu Login
</p>

Pada Gambar 4 merupakan menu login, pengguna diharuskan untuk memasukkan 
username dan password yang sudah didaftarkan sebelumnya.

<p align="center">
  <img width="500" alt="logo" src="Docs/8.png"/>
</p>

<p align="center">
    <b>Gambar 5</b> Tampilan Menu Beranda
</p>

Pada Gambar 5 merupakan tampilan menu beranda, pengguna dapat melihat berapa banyak 
face id yang terdaftar, jumlah orang yang masuk dan keluar pada hari tertentu.

<p align="center">
  <img width="500" alt="logo" src="Docs/9.png"/>
</p>

<p align="center">
    <b>Gambar 6</b> Tampilan Menu Daftar Users
</p>

Pada Gambar 6 merupakan menu daftar users, pengguna dapat menambahkan users serta 
dapat mengubah _username_ dan _password_ untuk keperluan _login_ ke dalam _dashboard_.

<p align="center">
  <img width="500" alt="logo" src="Docs/10.png"/>
</p>

<p align="center">
    <b>Gambar 7</b> Tampilan Menu Data Alat
</p>

Pada Gambar 7 merupakan tampilan menu data alat, pengguna dapat melihat _device_ yang 
digunakan dalam proses presensi. Dalam hal ini, kita menggunakan _device_ Raspberry Pi 4 
modul B.

<p align="center">
  <img width="500" alt="logo" src="Docs/11.png"/>
</p>

<p align="center">
    <b>Gambar 8</b> Tampilan Menu Data Face ID
</p>

Pada Gambar 8 merupakan tampilan menu data face id, pengguna dapat melihat face id 
yang sudah terdaftar beserta data-data seperti nama, NIM, nomor telepon, gender, semester, 
dan kelas. Pengguna dapat mengedit data-data tersebut pada menu ini, sedangkan untuk 
menghapus data tersebut hanya admin yang mengatur _database_ yang dapat menghapus data-data tersebut.

<p align="center">
  <img width="500" alt="logo" src="Docs/12.png"/>
</p>

<p align="center">
    <b>Gambar 9</b> Tampilan Menu Absensi
</p>

<p align="center">
  <img width="500" alt="logo" src="Docs/14.png"/>
</p>

<p align="center">
    <b>Gambar 10</b> Tampilan Menu Absensi
</p>

Pada Gambar 9 dan 10 merupakan tampilan menu absensi, pengguna dapat melihat keterangan 
siapa saja yang sudah melakukan presensi beserta keterangan waktu dan juga suhu. Pada menu 
ini lah terdapat salah satu fitur utama sistem yaitu pengguna dapat mengunduh hasil rekapan presensi berdasarkan tanggal yang sudah ditentukan.

<p align="center">
  <img width="500" alt="logo" src="Docs/13.png"/>
</p>

<p align="center">
    <b>Gambar 11</b> Tampilan Menu Setting
</p>

Pada Gambar 11 merupakan tampilan menu setting, admin dapat mengatur waktu masuk, 
waktu keluar, jam masuk, serta dapat mengatur id chat telegram yang akan digunakan.

<p align="center">
  <img width="500" alt="logo" src="Docs/15.png"/>
</p>

<p align="center">
    <b>Gambar 12</b> Tampilan Bot Telegram
</p>

Jika berhasil melakukan presensi, Bot Telegram akan mengirimkan notifikasi dengan 
mengirimkan data berupa nama dan waktu seperti pada Gambar 12.

## More Information
#### Dokumentasi : https://drive.google.com/drive/folders/1Yhe3mZABtvIhFL2qMV13tX5cW1aH2uLo?usp=sharing
#### Video Demo : https://drive.google.com/file/d/1wwn57zQfufg_UVgRryQOE0lj2PYIVw0r/view?usp=sharing
