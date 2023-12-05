/**
 * Renders a single address item
 *  
 * @param {object} dataItem
 * @returns {HTMLDivElement}
 *  
 */


//TODO: retrieve from API
var ADDRESS_TYPE = JSON.parse(address_types);

function renderAddressItem(dataItem, label) {

    var item_container_div, header_div, name, type, lines, country, labelElement;

    labelElement = document.createElement('small');
    labelElement.classList.add('text-muted');
    labelElement.innerHTML = label;

    item_container_div = document.createElement('div');

    header_div = document.createElement('div');
    header_div.classList.add('d-flex', 'w-100', 'justify-content-between');

    name = document.createElement('h5');
    name.classList.add('mb-1');
    name.innerHTML = dataItem.contact.name;

    type = document.createElement('span');
    type.classList.add('badge', 'rounded-pill', 'text-bg-info', 'align-self-center');
    type.innerHTML = ADDRESS_TYPE[dataItem.type];

    header_div.appendChild(name);
    header_div.appendChild(type);

    lines = document.createElement('p');
    lines.classList.add('mb-1');
    lines.innerHTML = dataItem.line_1;
    if (dataItem.line_2) {
        lines.innerHTML = lines.innerHTML + '<br>' + dataItem.line_2;
    }

    country = document.createElement('small'); 
    country.innerHTML = dataItem.city + ', ' + dataItem.state + ' ' + dataItem.zip;
    if (dataItem.country) {
        country.innerHTML = country.innerHTML + '<br>' + dataItem.country;
    }

    item_container_div.appendChild(labelElement);
    item_container_div.appendChild(header_div);
    item_container_div.appendChild(lines);
    item_container_div.appendChild(country);

    return item_container_div;
}

function renderContactItemView(nodeId, data) {
    const node = document.getElementById(nodeId);
    const dataJson = JSON.parse(data);
    node.innerHTML = '';
    node.appendChild(renderAddressItem(dataJson.model, dataJson.label));
}