
'use strict';

document.addEventListener('DOMContentLoaded', () => {
    //const MarkdownIt = require('markdown-it');
    const markdownInput = document.getElementById("markdownContent");
    const displayContent = document.getElementById("displayContent");
    const updateBtn = document.getElementById("updateBtn"); // 更新ボタン
    const btn = document.getElementById("btn"); // 検索ボタン
    console.log('btn:', btn);
    console.log('updateBtn:', updateBtn);

    // MarkdownItのインスタンスを作成
    const markdown = new window.markdownit();

    if (updateBtn) {
        updateBtn.addEventListener('click', async () => {
            try {
                const recordId = window.location.pathname.split('/').pop();
                const res = await fetch(`/record/edit/${recordId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ content: markdownInput.value }),
                });
        
                const responseJson = await res.json();
        
                if (responseJson.success) {
                    const { updatedRecord } = responseJson;
                    console.log('client.js_updatedRecord:', updatedRecord);
        
                    // MarkdownをHTMLに変換して表示エリアにセット
                    displayContent.innerHTML = markdown.render(updatedRecord.Record_Content);
                    alert('更新が成功しました');
                } else {
                    console.error('Update failed:', responseJson.error);
                    alert('更新が失敗しました');
                }
            } catch (error) {
                console.error('Error updating record:', error);
            }
        });
    } else {
        console.error('updateBtn not found');
    }

    if (btn) {
        btn.addEventListener('click', async () => {
            const textValue = document.getElementById("formText").value;

            // セッションからユーザー情報を取得
            const user = JSON.parse(localStorage.getItem('user'));

            // ユーザーがログインしていない場合は/loginにリダイレクト
            // if (!user) {
            //     window.location.href = '/search/redirect-to-login';
            //     return;
            // }
    
            try {
                const res = await fetch(`/search?maxResults=40&text=${textValue}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ textValue }),
                });
    
                const { success, data } = await res.json();
    
                if (success && data.items) {
                    const bookItem = document.getElementById("bookItem");
                    bookItem.innerHTML = ""; // 以前の検索結果をクリア
    
                    data.items.forEach((item, i) => {
                        const bookImg = item.volumeInfo.imageLinks?.smallThumbnail || 'No Image';
                        const bookTitle = item.volumeInfo.title || 'No Title';
    
                        const makeElement = document.createElement("div");
                        makeElement.classList.add("book-card");
                        bookItem.appendChild(makeElement);
    
                        const getBookItem = document.getElementsByClassName("book-card")[i];
                        const setBookElement = `
                            <div class="book-details">
                                <img class="book-img" src="${bookImg}" alt="${bookTitle}">
                                <p class="card-text">${bookTitle}</p>
                                <button class="btn btn-primary" onclick="registerBook('${bookTitle}', '${bookImg}')">登録</button>
                            </div>
                        `;
                        getBookItem.innerHTML = setBookElement;
                    });
                } else {
                    console.error('Failed to fetch book data:', data);
                }
            } catch (error) {
                console.error('Error fetching book data:', error);
            }
        });
    } else {
        console.error('btn not found');
    }

    // 登録ボタンがクリックされたときの処理
    window.registerBook = async (title, imageUrl) => {
        try {
            const res = await fetch('/search/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ book: { title, image_url: imageUrl } }),
            });

            const { success, createdBook } = await res.json();

            if (success) {
                alert('登録が成功しました');
            } else {
                console.error('Failed to register book:', createdBook);
                alert('登録が失敗しました');
            }
        } catch (error) {
            console.error('Error registering book:', error);
            alert('登録中にエラーが発生しました');
        }
    };

});
