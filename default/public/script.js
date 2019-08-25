let btnAddNewArticle = document.querySelector('#addNewArticle').addEventListener('click',function () {
  let formNewArticle = document.querySelector('#formForNewArticle');
  formNewArticle.classList.remove('hiddeFormBlog');
  formNewArticle.classList.add('showFormBlog');
  console.log('ok');
})
