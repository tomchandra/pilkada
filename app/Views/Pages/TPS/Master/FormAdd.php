<?= $this->extend(config('SitesConfig')->themes); ?>
<?= $this->section('title'); ?>
Add - TPS
<?= $this->endSection(); ?>

<?= $this->section('buttons'); ?>
<a href="<?= base_url("pages/tps") ?>" type="button" class="btn btn-sm btn-bg-light btn-icon-muted btn-text-muted py-1"><i class="bi bi-arrow-left-circle-fill"></i>Back</a>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<form class="form w-100" action="<?= base_url("pages/tps/save") ?>" method="post">
   <?= csrf_field() ?>
   <div class="card card-bordered">
      <div class="card-body">
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span class="required">Nama TPS</span>
            </label>
            <input class="form-control form-control-sm form-control-solid" name="nama_tps">
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>Provinsi</span>
            </label>
            <select id="prov" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Select an option">
               <option></option>
               <?php if (count($prov) > 0) : ?>
                  <?php foreach ($prov as $key => $value) : ?>
                     <option value="<?= $value['kode']; ?>"><?= $value['nama'] ?></option>
                  <?php endforeach; ?>
               <?php endif; ?>
            </select>
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>Kabupaten/Kota</span>
            </label>
            <select id="kab" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Select an option">
               <option></option>
            </select>
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>Kecamatan</span>
            </label>
            <select id="kec" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Select an option">
               <option></option>
            </select>
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>Kelurahan/Desa</span>
            </label>
            <select name="kode_wilayah" id="kel" class="form-select form-select-sm form-select-solid" data-control="select2" data-placeholder="Select an option">
               <option></option>
            </select>
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>Alamat</span>
            </label>
            <textarea class="form-control form-control-sm form-control-solid" name="alamat_tps"></textarea>
         </div>
         <div class="mb-5">
            <label class="fs-7 fw-bold form-label mb-2">
               <span>Koordinat</span>
            </label>
            <div id="map" class="h-250px"></div>
            <input type="hidden" name="koordinat_long" id="koordinat_long">
            <input type="hidden" name="koordinat_lat" id="koordinat_lat">
         </div>
         <div class="card-footer  d-flex justify-content-end gap-2 py-3">
            <button type="submit" class="btn btn-sm btn-primary">Save</button>
         </div>
      </div>
</form>
<?= $this->endSection(); ?>

<?= $this->section('extra_js'); ?>
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
<script>
   "use strict";

   const MAIN = function() {

      const handleChained = () => {

         $('#prov').on('select2:select', function(e) {
            var prov_id = e.params.data.id;

            $('#kab').val(null).trigger('change');
            $("#kab").select2({
               ajax: {
                  url: host_url + '/chained',
                  type: "post",
                  dataType: 'json',
                  delay: 250,
                  data: function(params) {
                     return {
                        charLength: 5,
                        left: 2,
                        searchTerm: prov_id
                     };
                  },
                  processResults: function(response) {
                     return {
                        results: response
                     };
                  },
                  cache: true
               }
            });

         });

         $('#kab').on('select2:select', function(e) {
            var kab_id = e.params.data.id;

            $('#kec').val(null).trigger('change');
            $("#kec").select2({
               ajax: {
                  url: host_url + '/chained',
                  type: "post",
                  dataType: 'json',
                  delay: 250,
                  data: function(params) {
                     return {
                        charLength: 8,
                        left: 5,
                        searchTerm: kab_id
                     };
                  },
                  processResults: function(response) {
                     return {
                        results: response
                     };
                  },
                  cache: true
               }
            });
         });

         $('#kec').on('select2:select', function(e) {
            var kec_id = e.params.data.id;

            $('#kel').val(null).trigger('change');
            $("#kel").select2({
               ajax: {
                  url: host_url + '/chained',
                  type: "post",
                  dataType: 'json',
                  delay: 250,
                  data: function(params) {
                     return {
                        charLength: 13,
                        left: 8,
                        searchTerm: kec_id
                     };
                  },
                  processResults: function(response) {
                     return {
                        results: response
                     };
                  },
                  cache: true
               }
            });
         });
      }

      const handleMaps = () => {
         mapboxgl.accessToken = 'pk.eyJ1IjoidG9taWNhbmRyYSIsImEiOiJja3k4MDlvenIxYXVqMm9tbnd2bzhuNjV2In0.NK-5AunM5VVr09OAuXLB_Q';
         var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [106.84707538650798, -6.196151494672293],
            zoom: 15
         });
         map.on('style.load', function() {
            map.on('click', function(e) {
               var coordinates = e.lngLat;

               document.getElementById('koordinat_lat').value = coordinates.lat;
               document.getElementById('koordinat_long').value = coordinates.lng;

               new mapboxgl.Popup()
                  .setLngLat(coordinates)
                  .setHTML('you clicked here: <br/>' + coordinates)
                  .addTo(map);
            });
         });
         map.addControl(new mapboxgl.NavigationControl());
         map.addControl(
            new mapboxgl.GeolocateControl({
               positionOptions: {
                  enableHighAccuracy: true
               },
               // When active the map will receive updates to the device's location as it changes.
               trackUserLocation: true,
               // Draw an arrow next to the location dot to indicate which direction the device is heading.
               showUserHeading: true
            })
         );
      }

      return {
         init: function() {
            handleChained();
            handleMaps();
         }
      };
   }();


   KTUtil.onDOMContentLoaded(function() {
      MAIN.init();
   });
</script>
<?= $this->endSection(); ?>