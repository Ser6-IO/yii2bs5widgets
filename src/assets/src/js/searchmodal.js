
async function getAddresses(url, params) {

    const _params = new URLSearchParams(params);
   
    //headers={"content-type": "application/json"}??

    const response = await fetch(`${url}?${_params}`);

    return response.json();
}

function itemClick(e, hidden_input, card, search_modal, search_input, formId) {
                                            
    hidden_input.value = e.currentTarget.getAttribute('data-hidden_input');
    card.innerHTML = e.currentTarget.innerHTML;

    search_modal.hide();
    parent.innerHTML = '';
    search_input.value = '';

    //Validate after selection | alternative: $('#w0').yiiActiveForm('validate', true);
    $(`#${formId}`).yiiActiveForm('validateAttribute', hidden_input.id);
}


function renderResultItem(dataItem, label) {

    var search_result_item, item_container_div;

    search_result_item = document.createElement('a');
    search_result_item.classList.add('list-group-item', 'list-group-item-action', 'search-result-item');
    search_result_item.href = '#';
    search_result_item.setAttribute('data-hidden_input', dataItem.id);
    search_result_item.setAttribute('data-contact_name', dataItem.contact.name);
    
    item_container_div = renderAddressItem(dataItem, label);

    search_result_item.appendChild(item_container_div);

    return search_result_item;

}
  
function renderSearchResults(parent, data, hidden_input, card, search_modal, search_input, label, formId) {

    parent.innerHTML = '';

    var search_result_item;

    for(i = 0; i < data.length; i++) {

        search_result_item = renderResultItem(data[i], label);

        search_result_item.addEventListener('click', (e) => itemClick(e, hidden_input, card, search_modal, search_input, formId));

        parent.appendChild(search_result_item);
    }
    
}

function initCard(card, model, label) {
    if (model) {
        card.appendChild(renderAddressItem(model, label));
    } else {
        card.innerHTML = `<span>${label} <i class="bi bi-search"></i></span>`;
    }
}

function initSearchWidget(search_widget_data) {

    var widget_data = JSON.parse(search_widget_data);

    const widgetLabel = widget_data.label;
    const hiddenInputId = widget_data.hiddenInputId;
    const hiddenInputName = widget_data.hiddenInputName;
    const searchUrl = widget_data.searchUrl;
    const formId = widget_data.formId;
    
    var hidden_input = document.getElementById(hiddenInputId);
    var card = document.getElementById(hiddenInputId + '-card');
    var search_input = document.getElementById(hiddenInputId + '-search-input');
    var search_results = document.getElementById(hiddenInputId + '-search-results');
    const modalElement = document.getElementById(hiddenInputId + '-modal');

    const search_modal = new bootstrap.Modal(modalElement)
    modalElement.addEventListener('shown.bs.modal', () => {
        search_input.focus()
    })
    modalElement.addEventListener('hide.bs.modal', () => {
        search_input.value = '';
        search_results.innerHTML = '';
    })

    initCard(card, widget_data.model, widgetLabel);
    card.style.cursor = "pointer";
    card.addEventListener('click', function(e) {
        search_modal.show();
    });

    //On document ready, Add field to ActiveForm
    $(document).ready(function() {
        $(`#${formId}`).yiiActiveForm('add', {
            id: hiddenInputId,
            name: hiddenInputName,
            container: `.field-${hiddenInputId}`,
            input: `#${hiddenInputId}`,
            error: '.invalid-feedback',
            validate:  function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {message: `${widgetLabel} cannot be blank.`});
            }
        });
        $(`#${formId}`).on('afterValidateAttribute', function (event, attribute, messages) {
            if (attribute.id == hiddenInputId) {
                const cardBorder = document.getElementById(`${hiddenInputId}-card`);
                cardBorder.style.borderColor =  messages.length ? "var(--bs-danger)" : cardBorder.style.borderColor = "var(--bs-success)";
            }
        });
        
    });    
    
    search_input.addEventListener('keyup', function(e) {

        if (this.value.length > 0) {
            
            const params = {
                "name" : this.value,
            };
            
            getAddresses(searchUrl, params)
                .then((data) => {     
                    renderSearchResults(search_results, data, hidden_input, card, search_modal, search_input, widgetLabel, formId)    
                })   
                .catch(error => {
                    console.log(error);
                });

        } else {
            search_results.innerHTML = '';  
        }

    });

}
