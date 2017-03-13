var replacements = {
    "æ": "ae",
    "å": "a",
    "ä": "a",
    "ß": "ss",
    "ö": "o",
    "ü": "u",
    "đ": "dj",
    "ж": "zh",
    "х": "kh",
    "ц": "tc",
    "ч": "ch",
    "ш": "sh",
    "щ": "shch",
    "ю": "iu",
    "я": "ia",
    ":": "-",
    ",": "-",
    "à": "a",
    "á": "a",
    "â": "a",
    "è": "e",
    "é": "e",
    "ë": "e",
    "ê": "e",
    "ě": "e",
    "ì": "i",
    "í": "i",
    "ï": "i",
    "î": "i",
    "õ": "o",
    "ò": "o",
    "ó": "o",
    "ô": "o",
    "ø": "o",
    "ù": "u",
    "ú": "u",
    "û": "u",
    "ů": "u",
    "ñ": "n",
    "ç": "ch",
    "č": "c",
    "ć": "c",
    "ď": "d",
    "ĺ": "l",
    "ľ": "l",
    "ń": "n",
    "ň": "n",
    "ŕ": "r",
    "ř": "r",
    "š": "s",
    "ť": "t",
    "ý": "y",
    "ž": "z",
    "а": "a",
    "б": "b",
    "в": "v",
    "г": "g",
    "д": "d",
    "е": "e",
    "ё": "e",
    "з": "z",
    "и": "i",
    "й": "i",
    "к": "k",
    "л": "l",
    "м": "m",
    "н": "n",
    "о": "o",
    "п": "p",
    "р": "r",
    "с": "s",
    "т": "t",
    "у": "u",
    "ф": "f",
    "ы": "y",
    "э": "e",
    "ę": "e",
    "ą": "a",
    "ś": "s",
    "ł": "l",
    "ż": "z",
    "ź": "z",
    "ə": "e",
    "ş": "sh",
    "ğ": "g",
    "ı": "i"
};

var nameField = {

    /**
     * Очищает лишние и транслирует символы
     * @param name
     * @returns {string|*}
     */
    sanitize: function(name) {

        // убераем пространство до и после
        name = jQuery.trim(name);
        name = name.toLowerCase();

        var srch;
        for(srch in replacements) {
            var repl = replacements[srch];
            if(name.indexOf(srch) > -1) {
                if(srch == '.') srch = '\\.';
                var re = new RegExp(srch, 'g');
                name = name.replace(re, repl);
            }
        }

        // удаляем все виды кавычек
        name = name.replace(/['"\u0022\u0027\u00AB\u00BB\u2018\u2019\u201A\u201B\u201C\u201D\u201E\u201F\u2039\u203A\u300C\u300D\u300E\u300F\u301D\u301E\u301F\uFE41\uFE42\uFE43\uFE44\uFF02\uFF07\uFF62\uFF63]/g, '');

        // неизвестные символы заменяем на тире
        name = name.replace(/[^-_.a-z0-9 ]/g, '-');

        // конвертирует пробелы в тире
        name = name.replace(/\s+/g, '-')

        // заменяем двойные тире на одинарные
        name = name.replace(/--+/g, '-');

        // заменяем двойные точки на одинарные
        name = name.replace(/\.\.+/g, '.');

        // убераем корявые комбинации
        name = name.replace(/(\.-|-\.)/g, '-');

        // удаляем в начале и в конце точки, тире и подчеркивания
        name = name.replace(/(^[-_.]+|[-_.]+$)/g, '');

        // убеждаемся что имя не слишком длинное
        if(name.length > 128) name = $.trim(name).substring(0, 128).split("-").slice(0, -1).join(" ");

        return name;
    },

    /**
     * Обновляет полный путь (preview)
     * @param $t
     * @param value
     */
    updatePreview: function($t, value) {
        //var $previewPath = $('#' + $t.attr('id') + '_path');
        var $previewPath = $('.nameField_path[data-name="'+$t.attr('data-name')+'"]');
        var slash = parseInt($previewPath.attr('data-slashUrls')) > 0 ? '/' : '';
        $previewPath.find("strong").text((value.length > 0 ? value + slash : ''))
    }
};

$(function () {
    $(document).on("keyup", ".nameField", function() {
        var value = nameField.sanitize($(this).val());
        nameField.updatePreview($(this), value);

    }).on("blur", ".nameField", function() {
        var value = nameField.sanitize($(this).val());
        $(this).val(value);
        nameField.updatePreview($(this), value);
    });
    $(document).on("reloaded", ".nameField", function() {
        $(this).keyup();
    });
    $(".nameField").keyup();
});


/**
 * Convert a title/headline to an ASCII URL name
 *
 * 1. Convert accented characters to the ASCII equivalent.
 * 2. Convert non -_a-z0-9. to blank.
 * 3. Replace multiple dashes with single dash.
 *
 */


$(document).ready(function() {

    var $nameField = $(".nameField");

    // check if namefield exists, because pages like homepage don't have one and
    // no need to continue if it already has a value
    if(!$nameField.length || $nameField.val().length) return;

    var $titleField = $(".titleField");
    var active = true;

    //$(".InputfieldPageName .LanguageSupport input[type=text]").each(function() {
    //    // if language support enabled and any of the page names contains something
    //    // then prevent title from populating name fields
    //    if($(this).val().length > 0) active = false;
    //});

    var titleKeyup = function() {
        if(!active) return;
        // var val = $(this).val().substring(0, 128);
        var val = $(this).val(); // @adrian
        //var id = $(this).attr('id').replace(/Inputfield_title_*/, 'Inputfield__pw_page_name');
        $nameField = $('.nameField[data-name="'+$(this).attr('data-name-link')+'"]');
        if($nameField.size() > 0) $nameField.val(val).trigger('blur');
    }

    // $titleField.keyup(titleKeyup);
    if(active) $titleField.bind('keyup change', titleKeyup);

    // $nameField.focus(function() {
    if(active) $('.nameField').focus(function() {
        // if they happen to change the name field on their own, then disable
        if($(this).val().length) active = false;
    });

});