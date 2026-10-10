<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * Isi blog: 12 artikel yang menjelaskan 8 requirement Tugas Rutin 10
 * (nomor 1-8) dan 3 bonus (nomor 9-12 mencakup pagination dan tiga bonus).
 * Post nomor 1 dibuat paling baru, jadi tampil paling atas di daftar.
 */
class PostSeeder extends Seeder
{
    public function run(): void
    {
        $artikel = [
            [
                'title'   => 'Route::resource dan Named Routes di Laravel',
                'content' => implode("\n\n", [
                    'Route::resource adalah cara paling ringkas untuk membuat semua route CRUD sekaligus. Cukup satu baris, Route::resource(\'posts\', PostController::class), dan Laravel mendaftarkan tujuh route: index, create, store, show, edit, update, dan destroy.',
                    'Setiap route otomatis diberi nama dengan pola posts.index, posts.create, dan seterusnya. Nama ini dipanggil di view lewat helper route(), misalnya route(\'posts.edit\', $post). Keuntungannya, kalau alamat URL berubah, kita tidak perlu mengubah link di view satu per satu.',
                    'Seluruh daftar route yang terdaftar bisa dilihat dengan perintah php artisan route:list.',
                ]),
            ],
            [
                'title'   => 'PostController Resource dengan 7 Method',
                'content' => implode("\n\n", [
                    'Controller dibuat dengan perintah php artisan make:controller PostController --resource. Tujuh method di dalamnya punya tugas yang jelas: index menampilkan daftar, create menampilkan form kosong, store menyimpan data baru, show menampilkan satu post, edit menampilkan form berisi data lama, update menyimpan perubahan, dan destroy menghapus data.',
                    'Pola yang mudah diingat: create dan edit hanya menampilkan form, sedangkan store dan update yang benar-benar menyimpan ke database. Pada blog ini controller sengaja dibuat tipis. Validasi dipindah ke PostRequest dan query pencarian dipindah ke model, jadi controller hanya mengatur alur.',
                ]),
            ],
            [
                'title'   => 'Blade Layout Master dengan @extends dan @yield',
                'content' => implode("\n\n", [
                    'Layout master adalah kerangka halaman yang dipakai bersama. Bagian head, navbar, area pesan, dan footer ditulis sekali saja di layouts/app.blade.php. Di dalamnya ada beberapa lubang berupa @yield(\'title\') dan @yield(\'content\').',
                    'Halaman lain tinggal memakai @extends(\'layouts.app\') lalu mengisi lubang itu dengan @section. Hasilnya navbar dan footer otomatis muncul di semua halaman, dan perubahan desain cukup dilakukan di satu file.',
                ]),
            ],
            [
                'title'   => 'Membuat Blade Component Alert dan Card',
                'content' => implode("\n\n", [
                    'Component adalah potongan tampilan yang bisa dipakai berulang. File di folder resources/views/components otomatis menjadi tag, misalnya alert.blade.php dipanggil dengan x-alert. Blog ini punya dua component: Alert untuk pesan sukses atau gagal, dan Card untuk kartu post.',
                    'Alert menerima atribut type (success, error, atau info) yang menentukan warnanya. Card punya slot utama serta dua slot opsional bernama image dan footer. Isi di antara tag pembuka dan penutup masuk ke variabel $slot.',
                ]),
            ],
            [
                'title'   => 'Validasi Form, Error per Field, dan Old Input',
                'content' => implode("\n\n", [
                    'Validasi memastikan data yang masuk sudah benar sebelum disimpan. Di blog ini aturannya ada di PostRequest: judul wajib diisi dan panjangnya 3 sampai 150 karakter, isi post minimal 10 karakter, dan gambar harus berformat JPG, PNG, atau WEBP dengan ukuran maksimal 2 MB.',
                    'Kalau validasi gagal, Laravel mengembalikan pengguna ke form. Pesan kesalahan tampil tepat di bawah kolom yang salah lewat @error, dan isian yang sudah diketik tidak hilang karena form memakai old(). Pengguna tidak perlu mengetik ulang dari awal.',
                ]),
            ],
            [
                'title'   => 'Flash Message Sukses dan Gagal',
                'content' => implode("\n\n", [
                    'Flash message adalah pesan yang disimpan di session hanya untuk satu request berikutnya. Setelah ditampilkan sekali, pesan itu hilang sendiri. Cocok untuk memberi tahu hasil sebuah aksi.',
                    'Di controller dipakai redirect()->route(\'posts.index\')->with(\'success\', \'Post berhasil dibuat.\'). Kalau terjadi kesalahan, misalnya database gagal menyimpan, controller mengirim pesan dengan kunci error. Layout memeriksa kedua kunci itu lalu menampilkannya lewat component Alert, jadi semua halaman otomatis mendukung flash message.',
                ]),
            ],
            [
                'title'   => '@csrf dan @method pada Form',
                'content' => implode("\n\n", [
                    'Setiap form POST di Laravel wajib memakai @csrf. Directive ini menambahkan token rahasia ke form, dan permintaan tanpa token yang cocok ditolak dengan error 419. Tujuannya melindungi dari serangan CSRF, yaitu situs lain yang mengirim form palsu atas nama pengguna.',
                    'Browser hanya bisa mengirim GET dan POST. Untuk update dan hapus, form tetap memakai method POST lalu ditambah @method(\'PUT\') atau @method(\'DELETE\'). Laravel membaca field tersembunyi itu dan memperlakukan permintaannya sebagai PUT atau DELETE.',
                ]),
            ],
            [
                'title'   => 'Route Model Binding Menyederhanakan Controller',
                'content' => implode("\n\n", [
                    'Tanpa binding, controller harus mencari data sendiri dengan Post::findOrFail($id). Dengan Route Model Binding cukup menulis show(Post $post). Laravel melihat bagian {post} di URL, mengambil post dengan id tersebut, dan menampilkan halaman 404 otomatis kalau tidak ditemukan.',
                    'Pada blog ini binding dipakai di show, edit, update, dan destroy. Untuk post di tempat sampah, route restore dan force-delete memakai withTrashed() agar post yang sudah di-soft-delete tetap bisa ditemukan.',
                ]),
            ],
            [
                'title'   => 'Pagination agar Daftar Tetap Ringan',
                'content' => implode("\n\n", [
                    'Menampilkan semua data sekaligus akan terasa lambat kalau jumlah post sudah banyak. Pagination memecahnya menjadi halaman-halaman kecil. Di blog ini setiap halaman menampilkan 6 post lewat paginate(6).',
                    'Di view, tombol halaman dibuat dengan $posts->links(). Method withQueryString() ditambahkan supaya kata kunci pencarian tetap terbawa saat pengguna berpindah ke halaman berikutnya.',
                ]),
            ],
            [
                'title'   => 'Bonus: Fitur Pencarian dengan Query Scope',
                'content' => implode("\n\n", [
                    'Kotak pencarian di halaman daftar mengirim kata kunci lewat URL, misalnya ?q=laravel. Logika pencarian ditulis sebagai query scope scopeSearch di model Post, sehingga controller cukup memanggil Post::search($kata).',
                    'Scope itu mencari di kolom judul dan isi memakai LIKE. Kata kunci dikirim sebagai binding parameter, jadi aman dari SQL injection.',
                ]),
            ],
            [
                'title'   => 'Bonus: Soft Delete, Hapus Tanpa Kehilangan Data',
                'content' => implode("\n\n", [
                    'Dengan trait SoftDeletes, perintah delete tidak menghapus baris dari database. Laravel hanya mengisi kolom deleted_at, dan post itu otomatis tidak muncul di query biasa.',
                    'Karena datanya masih ada, post bisa dipulihkan dari halaman Tempat sampah lewat restore(). Kalau memang ingin dibuang selamanya, forceDelete() menghapus baris beserta file gambarnya. Cara kerjanya mirip Recycle Bin di Windows.',
                ]),
            ],
            [
                'title'   => 'Bonus: Upload Gambar ke Storage Public',
                'content' => implode("\n\n", [
                    'Form yang mengunggah file harus memakai enctype="multipart/form-data". Di controller, file disimpan dengan store(\'posts\', \'public\') yang menaruhnya di storage/app/public/posts, dan hanya path-nya yang dicatat di kolom image.',
                    'Agar bisa diakses dari browser, jalankan php artisan storage:link sekali untuk membuat tautan dari public/storage. Saat gambar diganti atau dihapus, file lama ikut dibersihkan supaya folder storage tidak penuh file yang tidak terpakai.',
                ]),
            ],
        ];

        foreach ($artikel as $i => $data) {
            $waktu = now()->subHours($i);   // artikel pertama paling baru

            $post = new Post();
            $post->fill($data);
            $post->created_at = $waktu;
            $post->updated_at = $waktu;
            $post->save();
        }
    }
}