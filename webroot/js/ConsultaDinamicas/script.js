$(document).ready(function() {
    $('thead th').each(function(index) {
        var column = $(this).text().toLowerCase();

        // if (column.indexOf('data') > -1 && column.indexOf('hora') == -1) {
        //     $(this).closest('table').find('tbody tr').each(function() {
        //         dateUnformated = $(this).find('td').eq(index).text();
        //         if (dateUnformated.trim().length && dateUnformated.trim() != '-') {
        //             $(this).find('td').eq(index).text(new Intl.DateTimeFormat('pt-BR').format(new Date(dateUnformated.trim())))
        //         }
        //     })
        // }

        // if (column.indexOf('data') > -1 && column.indexOf('hora') > -1) {
        //     $(this).closest('table').find('tbody tr').each(function() {
        //         dateUnformated = $(this).find('td').eq(index).text();
        //         if (dateUnformated.trim().length && dateUnformated.trim() != '-') {
        //             var data = new Date(dateUnformated.trim()).toLocaleString();
        //             $(this).find('td').eq(index).text(data)
        //         }
        //     })
        // }

        // if (column.indexOf('qtd') > -1 || column.indexOf('quantidade') > -1) {
        //     $(this).closest('table').find('tbody tr').each(function() {
        //         columnUnformated = $(this).find('td').eq(index).text();
                
        //         if(columnUnformated && columnUnformated.trim() != '-'){
        //             $(this).find('td').eq(index).text(parseInt(columnUnformated))
        //         }
        //     })
        // }
        
        // if (column.indexOf('peso') > -1) {
        //     $(this).text(column + ' (kg)');
        // }

        if (column.indexOf('valor') > -1) {
            $(this).closest('table').find('tbody tr').each(function() {
                columnUnformated = $(this).find('td').eq(index).text();
                $(this).find('td').eq(index).text(columnUnformated.replace('0000', ''))
                $(this).find('td').eq(index).addClass('mask-money2')
            })
        }

        if (column.indexOf('foto') > -1) {
            var count = 0;
            $(this).closest('table').find('tbody tr').each(function() {
                $(this).find('td').eq(index).find('img').each(function() {
                    var srcImage = $(this).attr('src');
                    $(this).attr('src', url + srcImage);
                    $(this).css('width', '200px');
                    $('<a href="' + url + srcImage + '"class="foto'+ count +'">').insertAfter($(this));
                })
                count++;
            })
        }

    })
})