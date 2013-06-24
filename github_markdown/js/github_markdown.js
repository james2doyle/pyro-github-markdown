(function($){
  function renderMarkdown($elem, message, callback) {
    $elem.html('<div class="md-loader"></div>');
    $.ajax({
      url: 'streams_core/public_ajax/field/github_markdown/md_preview',
      type: 'POST',
      dataType: 'html',
      data: {message: message},
      complete: function(xhr, textStatus) {
        if (callback && typeof(callback) === "function") {
          callback(xhr.responseText);
        }
      },
      success: function(data, textStatus, xhr) {
        // $elem.html('<div class="md-loader"></div>');
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log(xhr, textStatus, errorThrown);
      }
    });
  }
  $.fn.markdownField = function() {
    var $this = $(this);
    var slug = $this.attr('id');
    var $list = $this.find('li');
    var $writeArea = $this.find('.md-write-area');
    var $previewArea = $this.find('.md-preview-area');
    console.log($this, slug, $list, $writeArea, $previewArea);
    $list.on('click', function(e) {
      e.preventDefault();
      $list.removeClass('ui-state-active');
      $list.removeClass('ui-tabs-selected');
      $(this).addClass('ui-state-active');
      $(this).addClass('ui-tabs-selected');
      var target = $(this).children('a').attr('href');
      $('#'+slug).find('.form_inputs').addClass('ui-tabs-hide');
      $(target).removeClass('ui-tabs-hide');
      if (target == ('#md-preview-'+slug)) {
        renderMarkdown($previewArea, $writeArea.val(), function(res) {
          $previewArea.html(res);
        });
      }
      return false;
    });
    return $this;
  };
  $(document).ready(function() {
    $('.markdown-field').each(function(elem) {
      $(this).markdownField();
    });
  });
})(jQuery);