</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
   <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0
   </div>
   Prueba creada por <a href="https://manuelcanga.dev" target="_blank">Manuel Canga</a>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
   <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php foreach( $this->js_files['bottom'] as $js_file): ?>
   <script src="<?= $js_file ?>"></script>
<?php endforeach; ?>

</body>
</html>