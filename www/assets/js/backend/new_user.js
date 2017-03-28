/**
 * Created by nasia on 09.03.17.
 */

document.querySelector('#users form').addEventListener('submit', function(e){
    e.preventDefault();

    let newUser = new NewUser(this);
    newUser.validate();
    newUser.send();
    newUser.showErrors();
});