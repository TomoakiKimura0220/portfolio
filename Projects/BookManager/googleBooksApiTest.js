const fetch = require('node-fetch');

async function fetchBooksData() {
  const response = await fetch('https://www.googleapis.com/books/v1/volumes?q=javascript');
  const data = await response.json();
  console.log(data);
}

fetchBooksData();