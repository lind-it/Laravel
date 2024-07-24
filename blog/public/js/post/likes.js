document.addEventListener('DOMContentLoaded', ()=>{
    //находим кнопу лайка
    let likeBtn = document.querySelector('#like');

    //находим кнопу дизлайка
    let dislikeBtn = document.querySelector('#dislike');

    if (likeBtn.className.includes('btn-primary'))
    {
        likeBtn.addEventListener('click', remove);
    }

    else if (dislikeBtn.className.includes('btn-danger'))
    {
        dislikeBtn.addEventListener('click', remove);
    }

    else
    {
        //навешиваем обработчики на кнопки
        likeBtn.addEventListener('click', send);
        dislikeBtn.addEventListener('click', send);
    }

});



function send(e)
{
    let xhr = new XMLHttpRequest();

    xhr.open('POST', '/like/create');

    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    let formData = new FormData();

    //достаем id поста из ссылки
    let postId = window.location.href.split('/')[5];
    //получаем текущий csrf токен
    let token = document.forms.comment._token.value;

    formData.append('postId', postId);
    formData.append('_token', token);

    xhr.onload = ()=>
    {
        console.log(xhr.response);
    }

    if(e.target.id == 'like')
    {
        like(xhr, formData, e.target);
    }

    else if(e.target.id == 'dislike')
    {
        dislike(xhr, formData, e.target);
    }
}

function like(xhr, formData, button)
{
    formData.append('like', true);

    xhr.send(formData);

    xhr.onload = () =>
    {
        if (xhr.status == 200)
        {
            button.className += ' btn-primary';

            document.querySelector('#like').removeEventListener('click', send);
            document.querySelector('#dislike').removeEventListener('click', send);

            button.addEventListener('click', remove);

            //обновление счетчика лайков
            document.querySelector('#like-count').innerHTML = xhr.response;
        }

        else if(xhr.status == 401)
        {
            alert(xhr.response);
        }

        else
        {
            alert('не удалось поставть оценку');
        }
    }

}

function dislike(xhr, formData, button)
{
    formData.append('like', false);

    xhr.send(formData);

    xhr.onload = () =>
    {

        if (xhr.status == 200)
        {
            button.className += ' btn-danger';

            document.querySelector('#like').removeEventListener('click', send);
            document.querySelector('#dislike').removeEventListener('click', send);

            button.addEventListener('click', remove);

            //обновление счетчика лайков
            document.querySelector('#like-count').innerHTML = xhr.response;
        }

        else if(xhr.status == 401)
        {
            alert(xhr.response);
        }

        else
        {
            alert('не удалось поставть оценку')
        }
    }
}

function remove(e)
{
    let xhr = new XMLHttpRequest();

    xhr.open('POST', '/like/delete');

    let formData = new FormData();
    //достаем id поста из ссылки
    let postId = window.location.href.split('/')[5];
    //получаем текущий csrf токен
    let token = document.forms.comment._token.value;

    formData.append('postId', postId);
    formData.append('_token', token);
    formData.append('_method', 'DELETE');

    xhr.send(formData);

    xhr.onload = () =>
    {
        if (xhr.status == 200)
        {
            button = e.target;

            if(button.id == 'like')
            {
                button.className = button.className.replace('btn-primary', '');
            }

            else if(button.id == 'dislike')
            {
                button.className = button.className.replace(' btn-danger', '');
            }

            //обновление счетчика лайков
            document.querySelector('#like-count').innerHTML = xhr.response;


            button.removeEventListener('click', remove);
            document.querySelector('#like').addEventListener('click', send);
            document.querySelector('#dislike').addEventListener('click', send);
        }

        else
        {
            alert('не удалось удалить оценку');
        }
    }
}
