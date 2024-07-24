let comments = document.querySelector('#comments');
let postId = window.location.href.split('/')[5];

//получаем комментарии поста и создаем их
document.addEventListener('DOMContentLoaded', () =>
    {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', `/comment/get/${postId}`);

        xhr.send();

        xhr.onload = () =>
        {
            if (xhr.status == 200)
                {
                    let resp = JSON.parse(xhr.response);

                    for (let i = 0; i < resp.length; i++)
                    {
                        createComment(resp[i]);
                    }
                }
        }

    });

//отправляем комментарий по клику на кнопку
document.querySelector('#com-send').addEventListener('click', (e)=>
    {
        e.preventDefault();

        let xhr = new XMLHttpRequest();

        xhr.open('POST', `/comment/create`);

        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        let formData = new FormData(document.forms.comment);
        formData.append('postId', postId);

        xhr.send(formData);

        xhr.onload = () =>
        {

            if (xhr.status == 200)
            {
                let resp = JSON.parse(xhr.response);
                createComment(resp);
            }

            else if(xhr.status == 401)
            {
                alert(xhr.response);
            }

            else
            {
                alert('Не удалось отправить комментарий');
            }

        }
    });


function createComment(json)
{
    let elem = document.createElement('div');
    elem.className = 'mt-5';
    elem.id = json.id;

    let buttons = '';

    if (json.is_autor)
    {
        buttons =
        `
            <div id="buttons" class="row">
                <div id="change" class="col">
                    <a class="text-primary" href="">Изменить</a>
                </div>

                <div id="delete" class="col">
                    <a class="text-danger" href="">Удалить</a>
                </div>

                <div id="save" class="col" style="display:none;">
                    <a class="text-success"  href="">Сохранить</a>
                </div>
            </div>
        `;
    }

    html =
    `
        <h5>${json.user_name}</h5>
        <p id="text" class="border border-secondary-subtle text-start text-wrap p-3" style="height:100px;">${json.text}</p>

        ${buttons}
    `;


    elem.insertAdjacentHTML('beforeend', html);

    if (json.is_autor)
    {
        elem.querySelector('#change').addEventListener('click', changeComment);
        elem.querySelector('#delete').addEventListener('click', deleteComment);
        elem.querySelector('#save').addEventListener('click', saveChanges);
    }

    comments.appendChild(elem);

}

function changeComment(e)
{
    e.preventDefault();
    //находим ноду комментария
    let parent = e.target.parentNode.parentNode.parentNode;

    //находим текст комментария
    let textElem = parent.querySelector('#text');

    //убираем текст комментария
    textElem.style.display = 'none';

    //убираем кнопку изменить
    parent.querySelector('#change').style.display = 'none';

    //показываем кнопку сохранения
    parent.querySelector('#save').style.display = '';

    //получаем текущий csrf токен
    let token = document.forms.comment._token.value;

    let formHTML =
    `

        <form name="commentUpdate" action="/comment/update/${postId}/${parent.id}">
            <input type="hidden" name="_token" value="${token}">
            <input type="hidden" name="_method" value="PUT">
            <textarea class="border border-secondary-subtle text-start text-wrap p-3 w-100" name="text" id="">${textElem.innerHTML}</textarea>
        </form>

    `;

    parent.querySelector('#buttons').insertAdjacentHTML('beforeBegin', formHTML);

}

function saveChanges(e)
{
    e.preventDefault();
    //находим ноду комментария
    let parent = e.target.parentNode.parentNode.parentNode;

    let xhr = new XMLHttpRequest();

    xhr.open('POST', `/comment/update`);

    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    let formData = new FormData(document.forms.commentUpdate);
    formData.append('postId', postId);
    formData.append('commentId', parent.id);

    xhr.send(formData);

    xhr.onload = () =>
    {

        if (xhr.status == 200)
        {
            let commentUpdateForm = document.forms.commentUpdate;

            //находим текст комментария
            let textElem = parent.querySelector('#text');

            //обновляем текст комментария
            textElem.innerHTML = commentUpdateForm.text.value;

            //удаляем форму для изменения комметнатрия
            commentUpdateForm.remove();

            //убираем кнопку сохранения
            parent.querySelector('#save').style.display = 'none';

            //показываем кнопку изменения
            parent.querySelector('#change').style.display = '';
            console.log(parent.querySelector('#change'));

            //показываем текст комментария
            textElem.style.display = '';
        }

        else if(xhr.status == 401)
        {
            alert(xhr.response);
        }

        else
        {
            alert('Не удалось отправить комментарий');
        }
    }
}

function deleteComment(e)
{
    e.preventDefault();

    //находим ноду комментария
    let parent = e.target.parentNode.parentNode.parentNode;

    let xhr = new XMLHttpRequest();

    xhr.open('POST', '/comment/delete');

    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    let formData = new FormData();

    //достаем id поста из ссылки
    let postId = window.location.href.split('/')[5];

    //получаем текущий csrf токен
    let token = document.forms.comment._token.value;

    formData.append('postId', postId);
    formData.append('_token', token);
    formData.append('commentId', parent.id);
    formData.append('_method', 'DELETE');

    xhr.send(formData);

    xhr.onload = () =>
    {
        if (xhr.status == 200)
        {
            parent.remove();
        }

        else if(xhr.status == 401)
        {
            alert(xhr.response);
        }

        else
        {
            alert('не удалось удалить коммент');
        }

    }
}
