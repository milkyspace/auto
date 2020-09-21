jQuery(function() {
    'use strict';

    const KEY_ESCAPE = 27,
          KEY_LEFT   = 37,
          KEY_UP     = 38,
          KEY_RIGHT  = 39,
          KEY_DOWN   = 40;

    let filter           = /[-_,\.;:@#$%^&\*\[\]\(\)\\\+\s]/gim,
        $body            = jQuery('body'),
        $container       = jQuery('.section-city-select-form'),
        $lists           = $container.find('ul[data-group]'),
        $form            = $container.find('form'),
        $input           = $form.find('input[name="name"]'),
        group            = null,
        is_content_built = false,
        lists            = new Map();

    jQuery(document).on('click', '[data-role="city-select"]', function(e) {
        e.preventDefault();
        jQuery('#menu__toggle:checked').prop('checked', false);
        if (!is_content_built) {
            content_build();

            $lists = $container.find('ul[data-group]');

            show_active_group();

            $lists.each(function() {
                let $list = jQuery(this),
                    list  = new Map();

                $list.find('[data-name]').each(function() {
                    list.set(this, this.dataset.name.replace(filter, '').toLowerCase());
                });

                lists.set($list.data('group'), list);
            });

            is_content_built = true;
        }

        $body.addClass('city-selection');

        $form.find('input[name="name"]').trigger('focus');
    });

    jQuery(document).on('click', '[data-role="city-select-close"]', function(e) {
        e.preventDefault();

        $body.removeClass('city-selection');
    });

    jQuery(window).on('keydown', function(e) {
        if ($body.is('.city-selection') === false) {
            return;
        }

        if (e.which === KEY_ESCAPE) {
            e.preventDefault();
            e.stopPropagation();

            $body.removeClass('city-selection');

            return false;
        }

        if ([KEY_LEFT, KEY_UP, KEY_RIGHT, KEY_DOWN].indexOf(e.which) !== -1) {
            let $focus_a  = $lists.find('[data-role="city"] a:focus'),
                $focus_li = $focus_a.closest('[data-role="city"]'),
                $list     = $focus_a.closest('ul[data-group]'),
                $visible  = $list.find('[data-role="city"]:visible'),
                index     = $visible.index($focus_li);

            if (index !== -1) {
                if (e.which === KEY_UP && index > 0) {
                    $visible.eq(index - 1).find('a').trigger('focus');
                } else if (e.which === KEY_DOWN && index < $visible.length - 1) {
                    $visible.eq(index + 1).find('a').trigger('focus');
                }
            }

            e.preventDefault();
            e.stopPropagation();

            return false;
        }
    });

    $form.on('change', '[name="group"]', function(e) {
        show_active_group();
    });

    $form.on('reset', function(e) {
        $lists.removeClass('searching');
        $lists.find('[data-name]').removeClass('hidden');
        $lists.find('[data-role="sub-group"]').removeClass('hidden');

        setTimeout(show_active_group, 10);
    });

    $form.on('keydown keyup keypress', '[name="name"]', function(e) {
        let value = ($input.val() || '').replace(filter, '').toLowerCase();

        if ($input.data('search') === value) {
            return;
        }

        $input.data('search', value);

        search();
    });

    function content_build() {
        let html = '<div>Выбор города</div><hr>';

        for (let groupName in window.citySelectTree) {
            html += `<ul>`;

            let group = window.citySelectTree[groupName];

            for (let subGroupName in group) {
                let subGroup = group[subGroupName];

                for (let [name, url] of subGroup) {
                    let active = window.citySelectUrl === url;

                    html += `<li data-role="city" data-name="${name}" data-sub-group="${subGroupName}" class="${active ? 'active' : ''}"><a href="${url}">${name}</a></li>`;
                }
            }

            html += '</ul>';
        }

        $container.find('.content').html(html);
    }

    function show_active_group() {
        $form.serializeArray().forEach(({name, value}) => {
            if (name === 'group') {
                group = value;
            }
        });

        if (group) {
            $lists.hide().filter(`[data-group="${group}"]`).show();
        }

        search();
    }

    function search() {
        let search = ($input.val() || '').replace(filter, '').toLowerCase();

        if (search.length < 2) {
            $lists.removeClass('searching');
            $lists.find('[data-role="city"]').removeClass('hidden');
            $lists.find('[data-role="sub-group"]').removeClass('hidden');

            return;
        }

        $lists.addClass('searching');

        for (let [item, name] of lists.get(group)) {
            if (name.indexOf(search) === -1) {
                item.classList.add('hidden');
            } else {
                item.classList.remove('hidden');
            }
        }

        $lists.find('[data-role="sub-group"]').addClass('hidden');
        $lists.find('[data-role="city"][data-sub-group]:visible').each(function() {
            $lists.find(`[data-role="sub-group"][data-sub-group="${this.dataset.subGroup}"]`).removeClass('hidden');
        });
    }
});
