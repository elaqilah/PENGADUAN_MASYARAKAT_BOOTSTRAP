<div class="container">
  <div class="row">
    <div class="col-md-12" mt-3>
        <p>Selamat Datang <?php echo $_SESSION['nama']?></p>
        <div class="card">
            <div class="card-header">
                FORM PENGADUAN
            </div>
            <div class="card-body">
                <form action"" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Judul Laporan</label>
                    <input type="text" class="form-control" name="username" placeholder="Masukkan Judul Laporan" required>

                    <label class="form-label">Isi Laporan</label>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan Isi Laporan " required>

                    <label class="form-label">Foto</label>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan Foto" required>

            </div>
            <div class="card-footer">
                <button type="submit" name="kirim" class="btn btn-primary">Submit</button>
            </div>
            </form>

            <?php
            include ('../config/koneksi.php');
            $tanggal = date("Y-m-d");   
            if (isset($_POST['kirim'])){
                $nik = $_SESSION['nik'];
                $judul_laporan = $_POST['judul_laporan'];
                $isi_laporan = $_POST['isi_laporan'];
                $status = 0;
                $foto = $_FILES['foto']['nama'];
                $foto = $_FILES['foto']['tmp_nama'];
                $lokasi = '../assets/img/';
                $nama_foto = nama(0,999).'-'.$foto;

                move_uploaded_file($tmp,$lokasi.$nama_foto);
                $query = mysqli_query($koneksi, "INSERT INTO pengaduan VALUES('','$tanggal','$nik','$judul_laporan','$isi_laporan',
                '$nama_foto','$status')");

                echo"<scrpit>
                alert('Data berhasil dikirim!');
                window.location='index.php';
                </scrpit>"

            }
            ?>
        </div>
    </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 mt-3">
    <div class="card">
            <div class="card-header">
                RIWAYAT PENGADUAN
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>JUDUL</th>
                            <th>ISI</th>
                            <th>FOTO</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM `pegaduan` WHERE $nik='$nik' ORDER BY id_pengaduan DESC");
                        while ($data = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['judul_laporan']; ?></td>
                            <td><?php echo $data['isi_laporan']; ?></td>
                            <td><img src="../asset/img/<?php echo $data['foto']?>" width="100"</td>
                            <td>
                                <?php
                                if ($data['status'] == 'proses'){
                                    echo "<span class='badge bg-warning'>Proses</span>";
                                } elseif ($data['status'] == 'selesai'){
                                    echo "<span class='badge bg-warning'>Selesai</span>";
                                } else {
                                    echo "<span class='badge bg-succes'>Menunggu</span>"
                                }
                                
                                ?>
                            </td>
                            <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hapusModal<?php
                            data ['id_pengaduan'] ?>">
                                Hapus modal
                            </button>

                            <div class="modal fade" id="hapusModal<?php
                            data ['id_pengaduan'] ?>">" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="edit_data.php" method="POST">
                                            <input type="hidden" name="id_pengaduan" value="<?php echo $data['id_pengaduan']?>">
                                    <div class="modal-body">
                                        Apakah anda yakin akan menghapus data <br> <?php echo $data ['judul_laporan']?>
                                    </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger" name="hapus_pengaduan">Hapus</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>

                        <?php } ?>  
                        <tr>
                            
                        </tr>
                    </tbody>
                </table>
        
    </div>
  </div>
</div>