$(function () {

    var gallery = $('input[name="gallery[]"]');

    gallery.on('filesorted', function(event, params) {
        console.log('File sorted ', params.previewId, params.oldIndex, params.newIndex, params.stack);

        var sort = [];
        for (var i=0; i<params.stack.length; i++) {
            sort.push( params.stack[i].key );
        }


        $('input[name="gallery_sort"]').val( sort.join(',') );
    });


    gallery.on('filedeleted', function(event, key) {

        var sort = $('input[name="gallery_sort"]').val().split(',');
        var new_sort = [];

        for (var i=0; i<sort.length; i++) {
            if (sort[i] == key) { continue; }

            new_sort.push(sort[i]);
        }

        $('input[name="gallery_sort"]').val( sort.join(',') );

    });
});