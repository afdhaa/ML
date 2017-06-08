<div class="container">
  <div>
    <form class="" action="#" method="post" id="search">
      <div class="form-group">
        <input type="text" class="search" name="search">
      </div>
      <div class="form-group">
        <input type="button" name="button" onclick="cari()" value="Cari">
      </div>
    </form>
  </div>
</div>

<div class="container" id="valuesearch" hidden>
  <div class="panel panel-default">
    <div class="panel-heading">
      <input type="text" name="" id="judulnyah" disabled>
    </div>
    <div class="panel-body" id="isi">
      <div class="body">
        <table class="table table-bordered" id="table_issue">
          <thead>
            <th>NO</th>
            <th>Kandidat</th>
            <th>Issue</th>
            <th>Sub Issue</th>
            <th>Tone</th>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

function tampil(){
  // $('#table_issue').DataTable( {
  //     "ajax": '<?php echo base_url('index.php/search/coba') ?>'
  // });
}

function cari(){
  var tablenya;
  var dataSet;

  //console.log(dataSet);
  var url="<?php echo base_url('index.php/search/coba') ?>";
  $.ajax({
    url:url,
    type:"POST",
    data: $('#search').serialize(),
    dataType:"JSON",
    success:function(response){
      console.log(response);
      document.getElementById('valuesearch').hidden = false;
      document.getElementById('judulnyah').value=response.messages;
      dataSet=response;
      //console.log(dataSet.length);

      //   $('#table_issue').DataTable( {
      //     data: dataSet,
      //     columns: [
      //         { title: "NO" },
      //         { title: "Kandidat" },
      //         { title: "Issue" },
      //         { title: "Sub Issue" },
      //         { title: "Tone" }
      //     ]
      // } );
      //tablenya.ajax.reload();

    }
  })
}
</script>
