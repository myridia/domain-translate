async function domain_translate_init() {
  await domain_translate_object.init();
}
const domain_translate_object = {
  domain: "",
  domains: [],
  cookie: "googtrans",
  async init() {
    const trans_lang =
      "/" +
      domain_translate_data.source_lang_code +
      "/" +
      domain_translate_data.target_lang_code;

    this.domain = domain_translate_data.domain;
    this.domains = domain_translate_data.domains;
    if (trans_lang) {
      const cookie_value = await this.get_cookie_value(this.cookie);
      console.log(cookie_value);
      console.log(trans_lang);
      if (cookie_value != trans_lang) {
        await this.delete_cookies("googtrans", this.domain);
        await this.set_cookie(this.cookie, trans_lang, 60, this.domain);
        let translate = new google.translate.TranslateElement(
          {
            pageLanguage: domain_translate_data.source_lang_code,
            includedLanguages: Object.values(this.domains).join(","),
            autoDisplay: false,
            multilanguagePage: true,
          },
          "google_translate_element",
        );
      } else {
        let translate = new google.translate.TranslateElement(
          {
            pageLanguage: domain_translate_data.source_lang_code,
            includedLanguages: Object.values(this.domains).join(","),
            autoDisplay: false,
            multilanguagePage: true,
          },
          "google_translate_element",
        );
      }
    }
  },

  async delete_cookies(name, domain) {
    console.log(`...try to delete name: ${name}, domain:  ${domain}`);
    document.cookie =
      "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=.app.local; path=/";
    try {
      await cookieStore.delete({
        name: this.cookie,
        domain: "de.app.local",
      });
    } catch (error) {
      console.log(`...error deleting cookie: ${error}`);
    }

    cookieNames = (await cookieStore.getAll())
      .map((cookie) => cookie.name)
      .join(" ");
    console.log(`...cookies remaining: ${cookieNames}`);
  },

  async get_cookie_value(name) {
    const cookie = await cookieStore.get(name);
    let cookie_value = "";
    if (cookie) {
      if (Object.hasOwn(cookie, "value")) {
        cookie_value = cookie.value;
      }
    }
    return cookie_value;
  },

  async get_cookies(name) {
    const cookies = await cookieStore.getAll(name);

    // Iterate the cookies, or log that none were found
    if (cookies.length > 0) {
      console.log(`Found cookies: ${cookies.length}:`);
      cookies.forEach((cookie) => console.log(cookie));
    } else {
      console.log("Cookies not found");
    }
    return cookies;
  },

  get_cookiex(c_name) {
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
    //console.log(domain);
    try {
      await cookieStore.set({
        name: c_name,
        value: c_value,
        domain: domain,
        sameSite: "strict",
        path: "/",
        expires: Date.now() + 60 * 24 * 60 * 60 * 1000,
      });
    } catch (error) {
      console.log(`Error setting cookie1: ${error}`);
    }
  },
};
