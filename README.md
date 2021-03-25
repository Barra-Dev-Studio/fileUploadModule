# FileUpload
Modul ini merupakan modul untuk upload file atau gambar lebih tepatnya, dengan bantuan dari [Filepond](https://pqina.nl/filepond)
Pastikan install dulu ya.

Ada beberapa yang ditambahkan

1. Controller untuk mengatur controller
2. Service untuk berkomunikasi dengan database melalui model, dan fungsi lainnya
3. Migration untuk migrasi kolom

## Installasi
```
composer require barradev/fileuploadmodule
```

Setelah berhasil diinstal, jalankan perintah

```
php artisan fileuploadmodule:publish
```

## Route
Tambahkan route berikut
```php
Route::prefix('upload')->group(function () {
    Route::post('uploadTemp', [UploadController::class, 'store'])->name('upload.temp');
    Route::delete('uploadRevert/{id}', [UploadController::class, 'revert'])->name('upload.revert');
});
```
## Tambahkan ini di view, sesuai dengan dokumentasi Filepond
```html
// head
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />

// script
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script>
    FilePond.registerPlugin(); // Kalau mau install plugin

    const inputElement = document.querySelector('input[id="file"]');    // id input file nya
    const pond = FilePond.create(inputElement);
    FilePond.setOptions({
        server: {
            process: "{{ route('upload.temp') }}",
            revert: (uniqueFileId, load, error) => {
                $.ajax({
                    url: "{{ url('upload/uploadRevert') }}/" + uniqueFileId,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                })
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        },
        allowImagePreview: true,                // Optional harus install plugin dulu
        allowFileSizeValidation: true,          // Optional harus install plugin dulu
        imagePreviewHeight: 725,                // Optional harus install plugin dulu
        maxFileSize: "1024KB"                   // Optional harus install plugin dulu
    })
</script>
```
