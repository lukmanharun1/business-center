// inisialisasi
const cariAnime = document.getElementById("cari-anime");
const hasilAnime = document.getElementById("hasil-anime");

const API_ANIME = "https://api.jikan.moe/v3/search/anime?q=&rated=r17";

// ketika cari anime
cariAnime.addEventListener("keyup", function (e) {
  const valueCariAnime = e.target.value;
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == "4" && xhr.status == "200") {
      // ajax berhasil
      const resultAjax = JSON.parse(xhr.responseText);
      const hasil = resultAjax.results;
      let strukturHasil = ``;
      console.log(hasil);
      for (let i = 0; i < hasil.length; i++) {
        strukturHasil += `
          <div class="col-md-3 mt-3">
            <div class="card" >
              <img src="${hasil[i].image_url}" class="card-img-top" />
              <div class="card-body">
                <h5 class="card-title">Judul : <b>${hasil[i].title}</b></h5>
                <h6 class="card-title">Score : <b>${hasil[i].score}</b></h6>
                <a href="details-anime.php?mal_id=${hasil[i].mal_id}" class="btn btn-primary" target="_blank">Details</a>
              </div>
            </div>
          </div>`;
      }
      hasilAnime.innerHTML = strukturHasil;
    }
  };
  xhr.open(
    "GET",
    `https://api.jikan.moe/v3/search/anime?q=${valueCariAnime}&rated=pg`
  );
  xhr.send();
});
