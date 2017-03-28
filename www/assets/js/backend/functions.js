/**
 * Created by nasia on 02/02/17.
 */

'use strict';

/**
 * Add new user row
 */
function addNewRow(){
    // copy last node
    let newRow = document.querySelector('#users tbody tr:last-child').cloneNode(true);
    document.querySelector('#users tbody').appendChild(newRow);
    // change add/del links
    let allRows = document.querySelectorAll('.new_user');
    for(let i=0; i < allRows.length; ++i){
        allRows[i].className = 'new_user del';
        allRows[i].setAttribute('onclick', 'removeNewRow(this)');
    }
    allRows[allRows.length-1].className = 'new_user add';
    allRows[allRows.length-1].setAttribute('onclick', 'addNewRow()');

    // delete all values
    let perentTr = allRows[allRows.length-1].parentNode.parentNode;
    perentTr.querySelectorAll('input').forEach(function(item){
        item.value = '';
    });
}

/**
 * Remove row
 *
 * @param self
 */
function removeNewRow(self){
    self.parentNode.parentNode.parentNode.removeChild(self.parentNode.parentNode);
}