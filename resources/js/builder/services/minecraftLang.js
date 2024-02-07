import usFile from '../lang/en_us.json'

const getFile = () => {
    return usFile
}

const translate = (key) => {
    return getFile().hasOwnProperty(`item.minecraft.${key}`) ? getFile()[`item.minecraft.${key}`] : getFile()[`block.minecraft.${key}`];
}

const apiFunctions = {
    getFile,
    translate
};

export default apiFunctions;
