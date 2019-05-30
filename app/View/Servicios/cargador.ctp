<div class="modal fade" id="cargador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <div id="output"></div>
			<div class="progress">
			    <div class="progress-bar" role="progressbar" data-transitiongoal="99"></div>
			</div>
			<span>Espere un momento...</span>
      </div>
    </div>
  </div>
</div>

<script>
	$('#cargador').modal('show');
	$('.progress .progress-bar').progressbar({display_text: 'fill', use_percentage: false});
</script>