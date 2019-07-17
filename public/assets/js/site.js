var wk = {};
wk.init = function ()
{
    wk.formList         = document.querySelectorAll('form');
    if (wk.formList)
    {
        wk.formList.forEach(function(curForm){
            wk.form         = curForm;
            wk.formT        = wk.form.querySelector('[name=formTag]');
            wk.formK        = wk.form.querySelector('[name=formKey]');
            if (wk.formT && wk.formK)
            {
                wk.formValT     = wk.formT.value;
                wk.formValK     = wk.formK.value;
                wk.formT.value  = wk.formValK;
                wk.formK.value  = wk.formValT;        
            }    
        });

    }

    wk.formAjaxList         = document.querySelectorAll('form.ajax');
    if (wk.formAjaxList)
    {
        wk.formAjaxList.forEach(function(curForm){
            curForm.addEventListener('submit', wk.sendAjax);
        });
    }
};

wk.sendAjax = function (event)
{
    // blocage de l'envoi classique
    event.preventDefault();
    // récupération des infos du formulaire
    formData = new FormData(event.target);
    // protection antispam
    formData.set("formKey", php.formKey);
    wk.sendAjaxForm(formData, event.target);
}

wk.sendAjaxForm = function (formData, target)
{
    var formTag = formData.get("formTag");
    // envoi du formulaire en AJAX
    fetch("/api.json", {
                method: "POST",
                body: formData
    })
    .then(function(response) {
        // le serveur doit renvoyer du code JSON 
        return response.json(); 
    })
    .then((objResponse) => {
        // console.log(data);
        // affichage du message de confirmation
        if (target && formTag && objResponse[formTag])
            target.querySelector(".feedback").innerHTML = objResponse[formTag];

        // Ajax avec VueJS
        if((typeof app !== 'undefined') && objResponse['tabResult']) {
            app.tabResult = objResponse['tabResult'];
        }    
    });

}

// https://plainjs.com/javascript/events/running-code-when-the-document-is-ready-15/

// in case the document is already rendered
if (document.readyState!='loading')
{
    wk.init();
} 
else if (document.addEventListener)
{
    // modern browsers
    document.addEventListener('DOMContentLoaded', wk.init);
} 
else 
{
    // IE <= 8
    document.attachEvent('onreadystatechange', function(){
        if (document.readyState=='complete') wk.init();
    });
}
