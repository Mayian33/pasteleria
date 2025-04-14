document.querySelectorAll('.cards-title').forEach(title => {
    let productos = title.nextElementSibling; 
    let wrapper = document.createElement('div'); 

    wrapper.classList.add('categoria-container'); 
    title.parentNode.insertBefore(wrapper, title); 
    wrapper.appendChild(title);
    wrapper.appendChild(productos); 
});
