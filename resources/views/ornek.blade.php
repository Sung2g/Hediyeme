import React, { useState } from 'react';
import { 
  Search, ShoppingCart, User, Menu, Star, 
  ShieldCheck, Truck, CreditCard, ChevronRight, 
  Monitor, Gem, Sparkles, Droplets, BookOpen, Heart,
  Gift, Facebook, Twitter, Instagram, Mail, Phone, MapPin
} from 'lucide-react';

export default function App() {
  const [activeCategory, setActiveCategory] = useState('Tümü');

  const categories = [
    'Tümü', 'Dijital Hizmetler', 'Takı & Mücevher', 'Kişisel Bakım', 'Dini Ürünler', 'Ev & Yaşam'
  ];

  const featuredProducts = [
    { id: 1, name: "Zirkon Taşlı Gümüş Kolye", price: "850 TL", category: "Takı", icon: <Gem size={32} className="text-amber-500" />, color: "bg-amber-100" },
    { id: 2, name: "Bambu Ekolojik Diş Fırçası Seti", price: "120 TL", category: "Kişisel Bakım", icon: <Sparkles size={32} className="text-emerald-500" />, color: "bg-emerald-100" },
    { id: 3, name: "Oltu Taşı Gümüş Püsküllü Tesbih", price: "450 TL", category: "Dini Ürünler", icon: <BookOpen size={32} className="text-stone-600" />, color: "bg-stone-200" },
    { id: 4, name: "Organik Yüz Temizleme Jeli", price: "240 TL", category: "Güzellik", icon: <Droplets size={32} className="text-rose-400" />, color: "bg-rose-100" },
  ];

  return (
    <div className="min-h-screen bg-gray-50 font-sans text-gray-800">
      
      {/* HEADER / NAVBAR */}
      <header className="bg-white shadow-sm sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-20">
            {/* Logo */}
            <div className="flex-shrink-0 flex items-center gap-2 cursor-pointer">
              <div className="w-10 h-10 bg-rose-600 text-white rounded-xl flex items-center justify-center font-bold text-xl shadow-lg shadow-rose-200">
                <Gift size={24} />
              </div>
              <span className="font-extrabold text-2xl tracking-tight text-gray-900 hidden sm:block">
                hediyeme<span className="text-rose-600">.com</span>
              </span>
            </div>

            {/* Geniş Arama Çubuğu */}
            <div className="flex-1 max-w-2xl mx-8 hidden md:flex">
              <div className="relative w-full">
                <input 
                  type="text" 
                  placeholder="Ürün, kategori veya dijital hizmet arayın..." 
                  className="w-full pl-12 pr-4 py-3 rounded-full border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-rose-500 focus:ring-0 transition-all outline-none"
                />
                <Search className="absolute left-4 top-3.5 text-gray-400" size={20} />
                <button className="absolute right-2 top-2 bg-rose-600 text-white px-5 py-1.5 rounded-full text-sm font-medium hover:bg-rose-700 transition shadow-md shadow-rose-200">
                  Ara
                </button>
              </div>
            </div>

            {/* İkonlar */}
            <div className="flex items-center gap-4 sm:gap-6">
              <button className="md:hidden text-gray-600 hover:text-rose-600"><Search size={24} /></button>
              <button className="text-gray-600 hover:text-rose-600 flex flex-col items-center gap-1">
                <User size={22} />
                <span className="text-[10px] font-medium hidden sm:block">Hesabım</span>
              </button>
              <button className="text-gray-600 hover:text-rose-600 flex flex-col items-center gap-1 relative">
                <div className="relative">
                  <ShoppingCart size={22} />
                  <span className="absolute -top-2 -right-2 bg-rose-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-white">3</span>
                </div>
                <span className="text-[10px] font-medium hidden sm:block">Sepetim</span>
              </button>
            </div>
          </div>
        </div>

        {/* Kategori Navigasyonu */}
        <div className="border-t border-gray-100">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex space-x-8 overflow-x-auto py-3 no-scrollbar">
              <button className="flex items-center gap-2 text-rose-600 font-bold whitespace-nowrap">
                <Menu size={18} /> Tüm Kategoriler
              </button>
              {categories.slice(1).map((cat) => (
                <button key={cat} className="text-gray-600 hover:text-rose-600 font-medium whitespace-nowrap transition">
                  {cat}
                </button>
              ))}
            </div>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
        
        {/* HERO SECTION - BENTO BOX UI */}
        <section className="grid grid-cols-1 md:grid-cols-4 gap-4 h-auto md:h-[480px]">
          
          {/* Ana Vurgu (Dijital Hizmet) */}
          <div className="md:col-span-2 md:row-span-2 bg-gradient-to-br from-gray-900 via-gray-800 to-rose-900 rounded-3xl p-8 text-white flex flex-col justify-between relative overflow-hidden group cursor-pointer shadow-xl">
            <div className="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform duration-500">
              <Monitor size={200} />
            </div>
            <div className="relative z-10">
              <span className="bg-rose-500/30 text-rose-100 text-xs font-bold px-3 py-1 rounded-full border border-rose-400/30 backdrop-blur-sm">Dijital Çözümler</span>
              <h1 className="text-4xl sm:text-5xl font-extrabold mt-6 leading-tight">
                Profesyonel <br/><span className="text-transparent bg-clip-text bg-gradient-to-r from-rose-300 to-rose-100">E-Ticaret</span> Siteniz Hazır!
              </h1>
              <p className="mt-4 text-gray-300 max-w-sm">Tasarım, altyapı ve SEO kurulumu dahil anahtar teslim web tasarım paketleri.</p>
            </div>
            <div className="relative z-10 mt-8">
              <button className="bg-white text-gray-900 px-6 py-3 rounded-full font-bold shadow-lg hover:bg-rose-50 hover:text-rose-700 transition flex items-center gap-2">
                Paketleri İncele <ChevronRight size={18} />
              </button>
            </div>
          </div>

          {/* Güzellik & Takı Kutusu */}
          <div className="bg-rose-50 rounded-3xl p-6 flex flex-col justify-between cursor-pointer hover:shadow-md transition group">
            <div className="flex justify-between items-start">
              <div>
                <span className="text-rose-600 text-xs font-bold px-2 py-1 rounded-full bg-rose-200/50">Güzellik & Takı</span>
                <h3 className="text-xl font-bold mt-2 text-gray-800 group-hover:text-rose-600 transition">Zarafetinizi Taçlandırın</h3>
              </div>
              <div className="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-rose-500">
                <Heart size={24} />
              </div>
            </div>
            <p className="text-sm text-gray-500 mt-4">%40'a varan indirimler</p>
          </div>

          {/* Günlük Yaşam (Diş Fırçası vb) */}
          <div className="bg-emerald-50 rounded-3xl p-6 flex flex-col justify-between cursor-pointer hover:shadow-md transition group">
            <div className="flex justify-between items-start">
              <div>
                <span className="text-emerald-700 text-xs font-bold px-2 py-1 rounded-full bg-emerald-200/50">Günlük İhtiyaç</span>
                <h3 className="text-xl font-bold mt-2 text-gray-800 group-hover:text-emerald-600 transition">Doğal Bakım Ürünleri</h3>
              </div>
              <div className="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-emerald-500">
                <Sparkles size={24} />
              </div>
            </div>
            <p className="text-sm text-gray-500 mt-4">Çevre dostu seçimler</p>
          </div>

          {/* Dini Ürünler Kutusu */}
          <div className="md:col-span-2 bg-stone-100 rounded-3xl p-6 flex items-center justify-between cursor-pointer hover:shadow-md transition group overflow-hidden relative">
            <div className="relative z-10 w-2/3">
              <span className="text-stone-600 text-xs font-bold px-2 py-1 rounded-full bg-stone-200">Koleksiyon</span>
              <h3 className="text-2xl font-bold mt-2 text-gray-800">Özel Tasarım Tesbihler & Dini Eserler</h3>
              <p className="text-sm text-gray-500 mt-2">Usta işi, garantili oltu ve kehribar.</p>
            </div>
            <div className="w-24 h-24 bg-stone-200 rounded-full flex items-center justify-center relative z-10 group-hover:scale-110 transition-transform">
               <BookOpen size={40} className="text-stone-500" />
            </div>
            <div className="absolute right-0 -bottom-10 opacity-5 text-stone-900 group-hover:opacity-10 transition-opacity">
               <BookOpen size={150} />
            </div>
          </div>
        </section>

        {/* GÜVEN & HİZMET ROZETLERİ */}
        <section className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-x divide-gray-100">
            <div className="flex flex-col items-center gap-2 px-2">
              <div className="w-10 h-10 bg-rose-50 rounded-full flex items-center justify-center text-rose-600"><ShieldCheck size={20} /></div>
              <h4 className="font-bold text-sm text-gray-800">Güvenli Alışveriş</h4>
              <p className="text-xs text-gray-500">256-bit SSL Koruması</p>
            </div>
            <div className="flex flex-col items-center gap-2 px-2">
              <div className="w-10 h-10 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600"><Truck size={20} /></div>
              <h4 className="font-bold text-sm text-gray-800">Hızlı Kargo</h4>
              <p className="text-xs text-gray-500">Aynı gün teslimat seçeneği</p>
            </div>
            <div className="flex flex-col items-center gap-2 px-2">
              <div className="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-600"><Monitor size={20} /></div>
              <h4 className="font-bold text-sm text-gray-800">Anında Teslimat</h4>
              <p className="text-xs text-gray-500">Dijital ürünlerde anında kurulum</p>
            </div>
            <div className="flex flex-col items-center gap-2 px-2">
              <div className="w-10 h-10 bg-stone-100 rounded-full flex items-center justify-center text-stone-600"><CreditCard size={20} /></div>
              <h4 className="font-bold text-sm text-gray-800">Taksit İmkanı</h4>
              <p className="text-xs text-gray-500">Tüm kartlara 12 ay taksit</p>
            </div>
          </div>
        </section>

        {/* FIRSAT ÜRÜNLERİ (SWIMLANE) */}
        <section>
          <div className="flex justify-between items-end mb-6">
            <div>
              <h2 className="text-2xl font-bold text-gray-900">Karma Fırsatlar</h2>
              <p className="text-gray-500 text-sm mt-1">Farklı kategorilerden sizin için seçilenler</p>
            </div>
            <button className="text-rose-600 font-medium text-sm flex items-center hover:underline">
              Tümünü Gör <ChevronRight size={16} />
            </button>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {featuredProducts.map((product) => (
              <div key={product.id} className="bg-white rounded-2xl p-4 shadow-sm hover:shadow-xl transition-shadow border border-gray-100 group">
                <div className={`w-full h-48 ${product.color} rounded-xl mb-4 flex items-center justify-center group-hover:scale-[1.02] transition-transform`}>
                  {/* Gerçek resim yerine ikonik görsel tutucu */}
                  <div className="w-20 h-20 bg-white/50 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm">
                    {product.icon}
                  </div>
                </div>
                <div className="flex justify-between items-start mb-2">
                  <span className="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded">{product.category}</span>
                  <div className="flex text-amber-400"><Star size={14} fill="currentColor" /><Star size={14} fill="currentColor" /><Star size={14} fill="currentColor" /><Star size={14} fill="currentColor" /><Star size={14} fill="currentColor" /></div>
                </div>
                <h3 className="font-bold text-gray-800 line-clamp-2 h-10 mb-2">{product.name}</h3>
                <div className="flex items-center justify-between mt-4">
                  <span className="text-lg font-extrabold text-rose-600">{product.price}</span>
                  <button className="bg-gray-900 text-white p-2 rounded-xl hover:bg-rose-600 transition-colors">
                    <ShoppingCart size={18} />
                  </button>
                </div>
              </div>
            ))}
          </div>
        </section>

      </main>

      {/* YENİ VE KAPSAMLI FOOTER ALANI */}
      <footer className="bg-gray-900 text-gray-300 py-16 mt-12 border-t border-gray-800">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          
          {/* Üst Footer: Sütunlar */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12 border-b border-gray-800 pb-12">
            
            {/* 1. Sütun: Marka & Hakkımızda */}
            <div className="col-span-1 lg:col-span-1">
              <div className="flex items-center gap-2 mb-6">
                <div className="w-10 h-10 bg-rose-600 text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-lg shadow-rose-900/50">
                  <Gift size={20} />
                </div>
                <span className="font-extrabold text-2xl tracking-tight text-white">
                  hediyeme<span className="text-rose-500">.com</span>
                </span>
              </div>
              <p className="text-sm text-gray-400 mb-6 leading-relaxed pr-4">
                Sevdiklerinize ve kendinize en özel hediyeler, profesyonel dijital çözümlerden günlük kişisel bakıma kadar aradığınız her şey tek bir adreste.
              </p>
              <div className="flex gap-3">
                <a href="#" className="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all hover:-translate-y-1"><Facebook size={18} /></a>
                <a href="#" className="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all hover:-translate-y-1"><Instagram size={18} /></a>
                <a href="#" className="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all hover:-translate-y-1"><Twitter size={18} /></a>
              </div>
            </div>

            {/* 2. Sütun: Hızlı Linkler */}
            <div>
              <h3 className="text-white font-bold mb-6 uppercase text-sm tracking-wider">Kategoriler</h3>
              <ul className="space-y-3 text-sm text-gray-400">
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Dijital Hizmetler</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Takı & Mücevher</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Kişisel Bakım</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Dini Ürünler</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Ev & Yaşam</a></li>
              </ul>
            </div>

            {/* 3. Sütun: Müşteri Hizmetleri */}
            <div>
              <h3 className="text-white font-bold mb-6 uppercase text-sm tracking-wider">Müşteri Hizmetleri</h3>
              <ul className="space-y-3 text-sm text-gray-400">
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Hakkımızda</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Sipariş Takibi</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> İade ve Değişim Şartları</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Sıkça Sorulan Sorular</a></li>
                <li><a href="#" className="hover:text-rose-400 transition-colors flex items-center gap-2"><ChevronRight size={14} className="text-rose-600" /> Gizlilik ve Çerez Politikası</a></li>
              </ul>
            </div>

            {/* 4. Sütun: İletişim & Bülten */}
            <div>
              <h3 className="text-white font-bold mb-6 uppercase text-sm tracking-wider">İletişim & Bülten</h3>
              <ul className="space-y-4 text-sm text-gray-400 mb-6">
                <li className="flex items-start gap-3"><MapPin size={18} className="text-rose-500 flex-shrink-0 mt-0.5" /> <span>İstiklal Cad. No:123<br/>Sakarya, Türkiye</span></li>
                <li className="flex items-center gap-3"><Phone size={18} className="text-rose-500 flex-shrink-0" /> <span>+90 (850) 123 45 67</span></li>
                <li className="flex items-center gap-3"><Mail size={18} className="text-rose-500 flex-shrink-0" /> <span>destek@hediyeme.com</span></li>
              </ul>
              {/* Bülten Kayıt (jQuery ile AJAX isteği atılabilecek form yapısı) */}
              <form className="flex mt-4" onSubmit={(e) => e.preventDefault()}>
                <input 
                  type="email" 
                  placeholder="E-posta adresiniz" 
                  className="bg-gray-800 border border-gray-700 text-sm text-white px-4 py-2.5 rounded-l-lg focus:outline-none focus:border-rose-500 w-full" 
                />
                <button 
                  type="submit" 
                  className="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2.5 rounded-r-lg transition-colors font-medium text-sm whitespace-nowrap"
                >
                  Abone Ol
                </button>
              </form>
            </div>
          </div>

          {/* Alt Footer: Telif ve Ödeme Yöntemleri */}
          <div className="flex flex-col md:flex-row justify-between items-center gap-6">
            <div className="text-sm text-gray-500 text-center md:text-left">
              &copy; {new Date().getFullYear()} hediyeme.com. Tüm hakları saklıdır.
            </div>
            
            {/* Tasarımsal Ödeme İkonları */}
            <div className="flex gap-3 opacity-70">
              <div className="w-12 h-8 bg-white rounded flex items-center justify-center text-[11px] font-extrabold text-blue-900 italic">VISA</div>
              <div className="w-12 h-8 bg-white rounded flex items-center justify-center text-[11px] font-extrabold text-red-600">MASTER</div>
              <div className="w-12 h-8 bg-white rounded flex items-center justify-center text-[11px] font-extrabold text-cyan-700">AMEX</div>
              <div className="w-12 h-8 bg-gray-800 rounded flex items-center justify-center text-[11px] font-extrabold border border-gray-600 text-white">TROY</div>
            </div>
          </div>
          
        </div>
      </footer>

    </div>
  );
}