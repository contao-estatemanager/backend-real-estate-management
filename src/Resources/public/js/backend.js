document.addEventListener('DOMContentLoaded', function () {
    // Loader
    window.onbeforeunload = function(){
        document.querySelector('#tl_real_estate > .loader').classList.add('load');
    }

    // Highlight errors
    const tabContents = document.querySelectorAll('.tab_cont');

    for(const tab of tabContents)
    {
        if(tab.querySelector('.widget .tl_error'))
        {
            const labelId = 'label_' + tab.id.replace('cont_', '');
            document.getElementById(labelId).classList.add('error');
        }
    }
});
