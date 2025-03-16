import { createI18n } from 'vue-i18n';
import lt from '../../lang/lt.json';
import en from '../../lang/en.json';

const messages = {
    lt: { ...lt },
    en: { ...en },
};

const i18n = createI18n({
    legacy: false,
    locale: localStorage.getItem('locale') || 'en',
    fallbackLocale: 'en',
    messages,
});

export {i18n};