Это из partials.comment.blade

<span>
    <a href="javascript:void(0);" class="reply" style="margin-left: 5px;" data-comment-id="{{ $comment->id }}">Відповісти</a>
</span>

Это из news.show.blade

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const commentForm = document.getElementById('comment-form');
            const commentsContainer = document.getElementById('comments-container');
           if (commentForm) {
                commentForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    const formData = new FormData(commentForm);
                    const url = commentForm.getAttribute('data-url');
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                       .then(response => response.text())
                        .then(data => {
                            commentForm.querySelector('textarea[name="text"]').value = '';
                            commentsContainer.insertAdjacentHTML('afterbegin', data);
                        })
                        .catch(error => {
                            console.error('Error:', error)
                        });
                });
            }
        });
      </script>
     <script>
    document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM fully loaded and parsed');
             const replyLink = document.querySelectorAll('.reply');
        replyLink.forEach(link => {
             link.addEventListener('click', function () {
                 const commentId = this.getAttribute('data-comment-id');
                 if (commentId) {
                     console.log('Comment ID:', commentId);
                 } else {
                     console.error('No comment ID found.');
                }
                 const form = document.getElementById(`reply-form-${commentId}`);
                 if(form) {
                     console.log('Form:', form);
                     form.style.display = form.style.display === 'none' ? 'block' : 'none';
                 } else {
                    console.error(`Form with id "reply-form-${commentId}" not found.`);
                 }
            });
         });
     });
    </script>
