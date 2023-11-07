
async function getAddresses(url, params) {

    const _params = new URLSearchParams(params);
   
    const response = await fetch(`${url}?${_params}`);

    return response.json();
}

function itemClick(e, hidden_input, card, search_modal, search_input) {
                                            
        hidden_input.value = e.currentTarget.getAttribute('data-hidden_input');
        card.innerHTML = e.currentTarget.innerHTML;

        search_modal.hide();
        parent.innerHTML = '';
        search_input.value = '';
    
}


function renderResultItem(dataItem, label) {

    var search_result_item, item_container_div;

    search_result_item = document.createElement('a');
    search_result_item.classList.add('list-group-item', 'list-group-item-action', 'search-result-item');
    search_result_item.href = '#';
    search_result_item.setAttribute('data-hidden_input', dataItem.id);
    search_result_item.setAttribute('data-organization_nickname', dataItem.organization.nickname);
    
    item_container_div = renderAddressItem(dataItem, label);

    search_result_item.appendChild(item_container_div);

    return search_result_item;

}
  
function renderSearchResults(parent, data, hidden_input, card, search_modal, search_input, label) {

    parent.innerHTML = '';

    var search_result_item;

    for(i = 0; i < data.length; i++) {

        search_result_item = renderResultItem(data[i], label);

        search_result_item.addEventListener('click', (e) => itemClick(e, hidden_input, card, search_modal, search_input));

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
    const searchUrl = widget_data.searchUrl;
    
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

    search_input.addEventListener('keyup', function(e) {

        if (this.value.length > 0) {
            
            const params = {
                "name" : this.value,
            };
            
            getAddresses(searchUrl, params)
                .then((data) => {     
                    renderSearchResults(search_results, data, hidden_input, card, search_modal, search_input, widgetLabel)    
                })   
                .catch(error => {
                    console.log(error);
                });

        } else {
            search_results.innerHTML = '';  
        }

    });

}
