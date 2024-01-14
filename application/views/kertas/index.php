<style>
  th:first-child {
    width: 50px;
  }

  table a {
    color: black;
    /* Normal link color */
  }

  table a:visited {
    color: black;
    /* Visited link color */
  }

  table a:hover {
    color: black;
    /* Hover link color */
  }
</style>

<section class="content mt-5">
  <div class="container-fluid">
    <div class="row small-gutter">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Folder Kertas Kerja 2022</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th style="width: 50px;">No</th>
                  <th>Nama Kategori</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($categories as $key => $category) : ?>
                  <tr>
                    <td><?php echo ($key + 1); ?>.</td>
                    <td><a href="<?= base_url("kertas/sub_kategori/" . $category->id) ?>"><?php echo $category->nama_kategori; ?></a></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
  </div>
</section>