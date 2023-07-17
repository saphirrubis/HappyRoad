import apiBackEnd from './api.Backend';
import { URL_BACK_PROFILE_VIEW } from '../../constants/urls/urlBackEnd';

export function profilView(config) {
    return apiBackEnd.get(URL_BACK_PROFILE_VIEW, config)
}