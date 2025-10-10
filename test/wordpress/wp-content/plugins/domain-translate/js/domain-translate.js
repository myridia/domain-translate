//window.onload = async function () {};

/*
  Function what get called by googles translator file request
  It will initiate the Google Language via the 'google.translate.TranslateElement' class
*/
function gtranslate_init() {
  const new_lang =
    "/" +
    domain_translate_data.source_lang_code +
    "/" +
    domain_translate_data.target_lang_code;

  langs = domain_translate_data.lang_codes;
  langs.push(domain_translate_data.source_lang_code);

  let translate = new google.translate.TranslateElement(
    {
      pageLanguage: domain_translate_data.source_lang_code,
      includedLanguages: langs.join(","),
      autoDisplay: false,
      multilanguagePage: true,
    },
    "google_translate_element",
  );

  console.log(new_lang);
  const lang = get_cookie("googtrans");
  if (lang === "" || lang !== new_lang) {
    set_cookie("googtrans", new_lang, 60);
    let x = setTimeout(() => {
      if (get_cookie("googtrans")) {
        //console.log("...reload page to set cookie");
        //window.location.reload();
      }
    }, 4 * 1000);
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
