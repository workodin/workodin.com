var wk = {};
wk.init = function ()
{
    wk.form         = document.querySelector('form');
    wk.formT        = wk.form.querySelector('[name=formTag]');
    wk.formK        = wk.form.querySelector('[name=formKey]');
    wk.formValT     = wk.formT.value;
    wk.formValK     = wk.formK.value;
    wk.formT.value  = wk.formValK;
    wk.formK.value  = wk.formValT;
};
wk.init();