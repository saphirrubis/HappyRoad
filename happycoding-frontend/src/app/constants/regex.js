export const REGEX_NAME = /^(?!.*[\s|-]{2,})[A-Za-z\-\sç'àâäéèêëîïôöûüùÿ]{1,50}$/;
export const REGEX_NAMESTART = /^[^\s|-]/;
export const REGEX_NAMEEND = /[^\s|-]$/;
export const REGEX_PASSWORD = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[ç&#@%$€µ£=*\-+/%_?.,;:!"'<>^(){}[\]|°§¤])[A-Za-z\dç&#@%$€µ£=*\-+/%_?.,;:!"'<>^(){}[\]|°§¤]{8,20}$/;
export const REGEX_SPACEDOUBLE = /(?!.*[\s]{2,})/;
export const REGEX_SPACESTART = /^[^\s]/;
export const REGEX_SPACEEND = /[^\s]$/;
export const REGEX_TEXT = /^(?!.*[\s]{2,})[\w-\sç'àâäéèêëîïôöûüùÿ?,;:!.()'"^]{1,200}$/;
export const REGEX_MSG = /^(?!.*[\s]{2,})[\w-\sç'àâäéèêëîïôöûüùÿ?,;:!.()'"^]{1,500}$/;
