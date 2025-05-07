document.addEventListener("DOMContentLoaded", function() {
    // Получаем элементы из DOM
    const transportRadios = document.querySelectorAll('.transport-radio');
    const deliveryPriceElement = document.getElementById('delivery-price');
    const totalPriceElement = document.getElementById('total-price');
    const productPriceElement = document.getElementById('product-price');
    const pickupRadio = document.getElementById('pickup');
    const pickupMap = document.querySelector('.pickup-map');

    // Инициализация базовых значений
    let productPrice = parseFloat(productPriceElement.textContent.replace(/[^0-9.-]+/g, ""));
    let deliveryPrice = 0;
    let lastSelectedRadio = null; // Переменная для хранения последней выбранной радиокнопки

    // Функция для обновления общей стоимости
    function updateTotalPrice() {
      const total = productPrice + deliveryPrice;
      totalPriceElement.textContent = `${total.toFixed(2)} руб.`;
    }

    // Добавляем обработчик событий на каждую радиокнопку
    transportRadios.forEach(radio => {
      radio.addEventListener('click', function() {
        if (lastSelectedRadio === this && this.checked) {
          // Если нажата уже выбранная радиокнопка, сбрасываем её
          this.checked = false;
          lastSelectedRadio = null; // Обнуляем последнюю выбранную кнопку
          deliveryPrice = 0; // Сбрасываем стоимость доставки
        } else {
          // Если выбрана новая радиокнопка
          lastSelectedRadio = this; // Сохраняем текущую радиокнопку
          const [transportName, transportCost] = this.value.split('|');
          deliveryPrice = parseFloat(transportCost); // Устанавливаем новую стоимость доставки
        }

        // Обновляем стоимость доставки и общую стоимость
        deliveryPriceElement.textContent = deliveryPrice > 0 ? `${deliveryPrice.toFixed(2)} руб.` : '0 руб.';
        updateTotalPrice();
      });
    });

    pickupRadio.addEventListener('click', () => {
      // Проверяем, выбрана ли радиокнопка "самовывоз"
      if (pickupRadio.checked) {
        // Переключаем видимость карты
        if (pickupMap.style.display === 'block') {
          pickupMap.style.display = 'none'; // Скрываем карту
        } else {
          pickupMap.style.display = 'block'; // Показываем карту
        }
      } else {
        pickupMap.style.display = 'none'; // Скрываем карту, если выбран другой вариант
      }
    });

  // Скрываем карту при выборе других вариантов доставки
  document.querySelectorAll('.transport-radio').forEach(radio => {
      if (radio.id !== 'pickup') {
          radio.addEventListener('change', () => {
              pickupMap.style.display = 'none';
          });
      }
  });
  });