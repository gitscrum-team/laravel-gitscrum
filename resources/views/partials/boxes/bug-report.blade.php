<div class="feedback right">
    <div class="tooltips">
        <div class="btn-group dropup">
            <button type="button" class="btn btn-primary dropdown-toggle btn-circle btn-lg"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bug fa-2x" title="{{_('Bug Report')}}"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-right dropdown-menu-form">
                <li>
                    <div class="report m-b-none">
                        <div class="col-lg-12">
                            <h4 class="m-t-sm">
                                <i class="fa fa-bug"></i>
                                {{_('Report Bug')}}
                            </h4>
                            <form method="post" action="">
                                 <input name="screenshot" type="hidden" class="screen-uri">
                                <textarea required name="comment" class="form-control" placeholder="{{_("Please tell us what bug or issue you've found, provide as much detail as possible")}}"></textarea>
                                <button class="btn btn-primary btn-block m-t-sm">{{_('Submit Report')}}</button>
                        </form>
                        </div>
                    </div>
                    <div class="loading text-center hideme">
                        <h2>Please wait...</h2>
                        <h2><i class="fa fa-refresh fa-spin"></i></h2>
                    </div>
                    <div class="reported text-center hideme">
                        <h2>Thank you!</h2>
                        <p>Your submission has been received, we will review it shortly.</p>
                        <div class="col-sm-12 clearfix">
                            <button class="btn btn-success btn-block do-close">Close</button>
                        </div>
                    </div>
                    <div class="failed text-center hideme">
                        <h2>Oh no!</h2>
                        <p>It looks like your submission was not sent.<br><br><a href="mailto:">Try contacting us by the old method.</a></p>
                        <div class="col-sm-12 clearfix">
                            <button class="btn btn-danger btn-block do-close">Close</button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
$(function ( $ ) {
    $.fn.feedback = function(success, fail) {
    	self=$(this);
		self.find('.dropdown-menu-form').on('click', function(e){e.stopPropagation()})

		self.find('.screenshot').on('click', function(){
			self.find('.cam').removeClass('fa-camera fa-check').addClass('fa-refresh fa-spin');
			html2canvas($(document.body), {
				onrendered: function(canvas) {
					self.find('.screen-uri').val(canvas.toDataURL("image/png"));
					self.find('.cam').removeClass('fa-refresh fa-spin').addClass('fa-check');
				}
			});
		});

		self.find('.do-close').on('click', function(){
			self.find('.dropdown-toggle').dropdown('toggle');
			self.find('.reported, .failed').hide();
			self.find('.report').show();
			self.find('.cam').removeClass('fa-check').addClass('fa-camera');
		    self.find('.screen-uri').val('');
		    self.find('textarea').val('');
		});

		failed = function(){
			self.find('.loading').hide();
			self.find('.failed').show();
			if(fail) fail();
		}

		self.find('form').on('submit', function(){
			self.find('.report').hide();
			self.find('.loading').show();
			$.post( $(this).attr('action'), $(this).serialize(), null, 'json').done(function(res){
				if(res.result == 'success'){
					self.find('.loading').hide();
					self.find('.reported').show();
					if(success) success();
				} else failed();
			}).fail(function(){
				failed();
			});
			return false;
		});
	};
}( jQuery ));

$(document).ready(function () {
	$('.feedback').feedback();
});
</script>
