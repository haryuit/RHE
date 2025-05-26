// モバイルメニューの切り替え
document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.getElementById('menuToggle');
  const mobileMenu = document.getElementById('mobileMenu');
  
  menuToggle.addEventListener('click', function() {
    mobileMenu.classList.toggle('active');
    
    // ハンバーガーメニューのアニメーション
    const spans = menuToggle.querySelectorAll('span');
    if (mobileMenu.classList.contains('active')) {
      spans[0].style.transform = 'rotate(45deg) translate(5px, 6px)';
      spans[1].style.opacity = '0';
      spans[2].style.transform = 'rotate(-45deg) translate(7px, -8px)';
    } else {
      spans[0].style.transform = 'none';
      spans[1].style.opacity = '1';
      spans[2].style.transform = 'none';
    }
  });
  
  // アコーディオンの動作
  const accordionItems = document.querySelectorAll('.accordion-item');
  
  accordionItems.forEach(item => {
    const header = item.querySelector('.accordion-header');
    
    header.addEventListener('click', function() {
      // 現在のアイテムの状態を切り替え
      const isActive = item.classList.contains('active');
      
      // すべてのアイテムを閉じる
      accordionItems.forEach(accItem => {
        accItem.classList.remove('active');
      });
      
      // クリックされたアイテムが閉じていた場合は開く
      if (!isActive) {
        item.classList.add('active');
      }
    });
  });
  
  // カードのホバーエフェクト強化
  const pricingCards = document.querySelectorAll('.pricing-card');
  
  pricingCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      pricingCards.forEach(c => {
        if (c !== card) {
          c.style.opacity = '0.7';
          c.style.transform = 'scale(0.98)';
        }
      });
    });
    
    card.addEventListener('mouseleave', function() {
      pricingCards.forEach(c => {
        c.style.opacity = '1';
        if (!c.classList.contains('popular')) {
          c.style.transform = 'none';
        } else {
          c.style.transform = 'scale(1.03)';
        }
      });
    });
  });
  
  // フォームの送信処理
  const contactForm = document.getElementById('contactForm');
  
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // フォームデータの取得
      const firstName = document.getElementById('firstName').value;
      const lastName = document.getElementById('lastName').value;
      const email = document.getElementById('email').value;
      
      // 実際のプロジェクトではここでAPIリクエストを送信するなどの処理を行う
      
      // 送信成功メッセージ（デモ用）
      alert(`${lastName} ${firstName}様、お問い合わせありがとうございます。メールアドレス（${email}）宛に確認メールをお送りしました。`);
      
      // フォームのリセット
      contactForm.reset();
    });
  }
  
  // 入力フィールドのフォーカスエフェクト
  const formInputs = document.querySelectorAll('input, select, textarea');
  
  formInputs.forEach(input => {
    input.addEventListener('focus', function() {
      this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
      this.parentElement.classList.remove('focused');
    });
  });
  
  // 現在の年を取得してフッターに表示
  const currentYearElement = document.getElementById('currentYear');
  if (currentYearElement) {
    currentYearElement.textContent = new Date().getFullYear();
  }
  
  // スクロールアニメーション
  const animateOnScroll = function() {
    const elements = document.querySelectorAll('.pricing-card, .accordion-item, .contact-method');
    
    elements.forEach(element => {
      const elementPosition = element.getBoundingClientRect().top;
      const windowHeight = window.innerHeight;
      
      if (elementPosition < windowHeight - 100) {
        element.classList.add('animated');
      }
    });
  };
  
  // 初期実行
  animateOnScroll();
  
  // スクロール時に実行
  window.addEventListener('scroll', animateOnScroll);
});



