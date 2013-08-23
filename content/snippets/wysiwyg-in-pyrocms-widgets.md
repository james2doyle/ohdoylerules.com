/*
Title: WYSIWYG in PyroCMS Widgets
Date: 2012-11-10
Category: Snippets,Web
Template: post
Keywords: WYSIWYG, PyroCMS, Widgets
*/

I have been working on a site that uses [PyroCMS](https://www.pyrocms.com/ "PyroCMS Homepage"). I needed to build a custom widget that had a WYSIWYG textarea. This is what worked for me.

Add this to template in the constructors function.

#### pyrocms/system/cms/modules/widgets/controllers/admin.php

    // my new template
    $this->template
    ->set_partial('shortcuts', 'admin/partials/shortcuts')
    ->append_js('module::widgets.js')
    ->append_css('module::widgets.css')
    ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE));

The following javascript needs to be added to the top of your view/form.php file.

#### /widgets/mywysiwygwidget/views/form.php

    // my self special jquery
    (function($){
      $('textarea.wysiwyg-simple').ckeditor({
        // this is the config for the simple wysiwyg
        toolbar: [
          ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']
        ],
        width: '99%',
        height: 100,
        dialog_backgroundCoverColor: '#000',
        defaultLanguage: '',
        language: ''
      });
    })(jQuery);

Also, you need to have the wysiwyg-simple class on your textarea.

#### /widgets/mywysiwygwidget/views/form.php

    echo form_textarea(array('name'=> 'html', 'value' => $options['html'], 'class' => 'wysiwyg-simple'));
