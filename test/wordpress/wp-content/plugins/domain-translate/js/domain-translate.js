async function domain_translate_init() {
  await domain_translate_object.init();
}
const domain_translate_object = {
  domain: "",
  domains: [],
  cookie: "googtrans",
  async init() {
    const new_lang =
      "/" +
      domain_translate_data.source_lang_code +
      "/" +
      domain_translate_data.target_lang_code;

    //let langs = domain_translate_data.lang_codes;
    this.domain = domain_translate_data.domain;
    this.domains = domain_translate_data.domains;

    let translate = new google.translate.TranslateElement(
      {
        pageLanguage: domain_translate_data.source_lang_code,
        includedLanguages: Object.values(this.domains).join(","),
        autoDisplay: false,
        multilanguagePage: true,
      },
      "google_translate_element",
    );

    const lang = this.get_cookie(this.cookie);
    console.log("xxxxxxxxxxx");
    //await this.delete_cookies("googtrans", this.domain);

    if (lang === "" || lang !== new_lang) {
      await this.set_cookie(this.cookie, new_lang, 60, this.domain);
      //let x = setTimeout(() => {
      //  if (this.get_cookie("googtrans")) {
      //console.log("...reload page to set cookie");
      //window.location.reload();
      //  }
      //}, 4 * 1000);
    }
  },

  async delete_cookies(name, domain) {
    console.log("...try to delete cookie: " + name);
    try {
      await cookieStore.delete({
        name: this.cookie,
        domain: domain,
      });
    } catch (error) {
      console.log(`...error deleting cookie: ${error}`);
    }

    cookieNames = (await cookieStore.getAll())
      .map((cookie) => cookie.name)
      .join(" ");
    console.log(`...cookies remaining: ${cookieNames}`);
  },
  get_cookie(c_name) {
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
  },

  async set_cookie(c_name, c_value, exp_days, domain) {
    console.log("...set new cookie to:" + c_value);
    console.log(domain);
    const days = 60 * 24 * 60 * 60 * 1000;
    try {
      await cookieStore.set({
        name: c_name,
        value: c_value,
        domain: domain,
        sameSite: "strict",
        path: "/",
      });

      await cookieStore.set({
        name: c_name,
        value: c_value,
        sameSite: "strict",
        path: "/",
      });
    } catch (error) {
      console.log(`Error setting cookie1: ${error}`);
    }
  },
};
