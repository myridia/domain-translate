window.onload = async function () {
  const host = get_host();
  const lang = host.split(".")[0];
  if (lang === "en" || lang === "dk" || lang === "de") {
    if (typeof Storage !== undefined) {
      let sek_dkk = localStorage.getItem("sek_dkk");
      let sek_eur = localStorage.getItem("sek_eur");
      let sek_usd = localStorage.getItem("sek_usd");
      let sek_expire = localStorage.getItem("sek_expire");

      if (sek_dkk && sek_eur && sek_expire && sek_usd) {
        let time_now = Math.floor(Date.now() / 1000);
        if (time_now > sek_expire) {
          await set_rate();
        }
      } else {
        await set_rate(host);
      }
      await set_page_currency(lang);
    }
  }
};

/*
  Function what get called by googles translator file request
  It will initiate the Google Language via the 'google.translate.TranslateElement' class
*/
function gtranslate_init() {
  let translate = new google.translate.TranslateElement(
    {
      pageLanguage: "sv",
      includedLanguages: "en,da,de",
      autoDisplay: false,
      multilanguagePage: true,
    },
    "google_translate_element",
  );

  const _lang = get_cookie("googtrans");
  if (_lang === "") {
    //console.log("...cookie is not set ");
    const host = get_host();
    if (host) {
      let lang = host.split(".")[0];
      if (lang === "dk") {
        lang = "da";
      }
      //document.location.href =
      //document.location.href + "#googtrans(de|" + lang + ")";
      //console.log("...reload page to set cookie");
      set_cookie("googtrans", "/sv/" + lang, 60);

      let x = setTimeout(() => {
        if (get_cookie("googtrans")) {
          //console.log("...reload page to set cookie");
          window.location.reload();
        }
      }, 4 * 1000);
    }
  }
}

/*
  Function to look up for a browser cookie.
  It takes a cookie name and give back its value 
*/
function get_cookie(c_name) {
  if (document.cookie.length > 0) {
    c_start = document.cookie.indexOf(c_name + "=");
    if (c_start != -1) {
      c_start = c_start + c_name.length + 1;
      c_end = document.cookie.indexOf(";", c_start);
      if (c_end == -1) {
        c_end = document.cookie.length;
      }
      return unescape(document.cookie.substring(c_start, c_end));
    }
  }
  return "";
}

function set_cookie(c_name, c_value, exp_days) {
  let date = new Date();
  date.setTime(date.getTime() + exp_days * 24 * 60 * 60 * 1000);
  const expires = "expires=" + date.toUTCString();
  document.cookie = c_name + "=" + c_value + "; " + expires + "; path=/";
  document.cookie =
    c_name +
    "=" +
    c_value +
    "; " +
    expires +
    "; path=/" +
    "; domain = translate.local" +
    ";";
}

function get_host(ext = "html") {
  let u = String(location).split("/");
  for (let i = 1; i < u.length; i++) {
    if (u[i].indexOf(".") > 0 && u[i].indexOf(ext) < 0) {
      return u[i];
    }
  }
  return "";
}

async function set_rate(host) {
  if (typeof Storage !== undefined) {
    const a = JSON.parse(await aget_api("https://" + host + "/sek.json"));
    localStorage.setItem("sek_dkk", a["dkk"]["rate"]);
    localStorage.setItem("sek_eur", a["eur"]["rate"]);
    localStorage.setItem("sek_usd", a["usd"]["rate"]);
    localStorage.setItem("sek_expire", Math.floor(Date.now() / 1000) + 86400);
  }
}

async function aget_api(url) {
  return new Promise((resolve, reject) => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      return resolve(xhr.responseText);
    };
    xhr.onerror = function () {
      return reject(xhr.statusText);
    };
    xhr.send(null);
  });
}

async function set_page_currency(lang) {
  //console.log("...set page currency");
  let sek_dkk = localStorage.getItem("sek_dkk");
  let sek_eur = localStorage.getItem("sek_eur");
  let sek_usd = localStorage.getItem("sek_usd");
  let sek_expire = localStorage.getItem("sek_expire");
  if (sek_dkk && sek_eur && sek_usd && sek_expire) {
    let rate = sek_dkk;
    let sym = "DKK";

    if (lang === "en") {
      rate = sek_usd;
      sym = "USD";
    } else if (lang === "de") {
      rate = sek_eur;
      sym = "EUR";
    }

    let e = document.getElementsByTagName("bdi");
    for (let x = 0; x < e.length; x++) {
      const s = e[x].firstChild.textContent;
      if (is_number(s)) {
        const n = parseFloat(s);
        const r = parseFloat(sek_usd);
        const res = Math.round(n * rate * 100) / 100;
        e[x].firstChild.textContent = res;
        e[x].getElementsByTagName("span")[0].firstChild.textContent = " " + sym;
      }
    }
  }
}

function is_number(n) {
  return !!n.trim() && n * 0 == 0;
}
