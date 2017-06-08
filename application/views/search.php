<body>
  <div class="container">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Search</h3>
        </div>
        <div class="panel-body">
          <form class="" action="#" method="post" id="search" onsubmit="cari()">
            <div class="form-group">
              <input type="text" class="form-control" name="search" id="buatcari">
            </div>
            <div class="form-group">
              <button type="sumbit" class="btn btn-default" name="button" onclick="cari()" onKeydown=”Javascript: if (event.keyCode==13) cari();” value="Cari">
                Cari
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

<div class="container" id="twittersearch" hidden>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <input type="text"  name="" value="Data Twitter" id="judultwitter" disabled>
      </div>
      <div class="panel-body" id="isi">
        <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
      </div>
    </div>
  </div>
</div>
<div class="container" id="valuesearch" hidden>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <input type="text"  name="" id="judulnyah" value="Hasil" disabled>
      </div>
      <div class="panel-body" id="isi">
        <div class="body">
          <table class="table table-bordered" class="display" id="table_issue">
            <thead>
              <th>NO</th>
              <th>Kandidat</th>
              <th>Issue</th>
              <th>Sub Issue</th>
              <th>Tanggal</th>
              <th>Tone</th>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>







<script type="text/javascript">


var tablenya;
var dataSet;

function tampilissue(){
  tablenya=$('#table_issue').DataTable( {
    retrieve: true,
    data: dataSet,
    columns: [
        { title: "NO" },
        { title: "Kandidat" },
        { title: "Issue" },
        { title: "Sub Issue" },
        { title: "tanggal" },
        { title: "Tone" }
    ]
  } );
}
function cari(){
  $('#table_issue').DataTable().clear().destroy();
  var url="<?php echo base_url('index.php/search/coba') ?>";
  $.ajax({
    url:url,
    type:"POST",
    data: $('#search').serialize(),
    dataType:"JSON",
    success:function(response){

      console.log(response.messages);
      if (response.messages=="issue") {
        console.log(response);
        document.getElementById('twittersearch').hidden = true;
        document.getElementById('valuesearch').hidden = false;
        document.getElementById('judulnyah').value=response.messages;
        dataSet=response.isi;
        tampilissue();
      }else if (response.messages=="sumkandtonetgl") {
        document.getElementById('valuesearch').hidden = true;
        document.getElementById('twittersearch').hidden = false;
        //document.getElementById('judultwitter').value=response.isi[0].kandidat;
        var jml=response.isi.length;
        var positif=0;
        var negatif=0;
        var netral=0;
        var total=0;
        var text;


        for (var i = 0; i < jml; i++) {
          positif+=+response.isi[i].positif;
          negatif+=+response.isi[i].negatif;
          netral+=+response.isi[i].netral;
          total+=+positif+negatif+netral;

        }

        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: 'Twitter',
                align: 'center',
                verticalAlign: 'middle',
                y: 40
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: -50,
                        style: {
                            fontWeight: 'bold',
                            color: 'white'
                        }
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '75%']
                }
            },
            series: [{
                type: 'pie',
                name: 'response.messages.kandidat',
                innerSize: '50%',
                data: [
                    ['Positif',   +positif],
                    ['Negatif',       +negatif],
                    ['Netral', +netral]
                ]
            }]
        });
      }
      else if (response.messages=="error") {
        document.getElementById('valuesearch').hidden = true;
        document.getElementById('twittersearch').hidden = true;
        document.getElementById('buatcari').value = "";
        alert("Data tidak ada");
      }

    }
  })
}

const element = document.querySelector('form');
element.addEventListener('submit', event => {
  event.preventDefault();
  // actual logic, e.g. validate the form
  cari();
});

</script>
