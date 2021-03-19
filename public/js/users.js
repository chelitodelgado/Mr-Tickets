

function getUsers( url ) {

    fetch( url )
    .then( resp => resp.json() )
    .then( data => {

        const lista = document.getElementById('lista');
        const users = data;

        lista.innerHTML += `
        <li>
            <img src="" alt="User Image">
            <a class="users-list-name">Nombre</a>
            <span class="users-list-date">Username</span>
            <span class="badge bg-danger">Status</span>
        </li>
        `;

    }).catch( err => console.log(err) );

    return lista;

}
