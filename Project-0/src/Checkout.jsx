import { useState } from "react";

export default function Checkout({ product, onComplete, onBack}) {
    const [cardNumber, setCardNumber] = useState("");
    const [cardName, setCardName] = useState("");
    const [expiration, setExpiration] = useState("");
    const [cvv, setCvv] = useState("");

    function handlePurchase() {
        const cardChech = /^\d{16}$/;
        const expCheck = /^(0[1-9]|1[0-2])\/\d{2}$/;
        const cvvCheck = /^\d{3}$/;

        if (
            !cardChech.test(cardNumber) ||
            !expCheck.test(expiration) ||
            !cvvCheck.test(cvv)
        ) {
            alert("Please enter valid card info.");
            return;
        }

        onComplete();
    }

    return (
        <>
        <h1>Checkout</h1>

        <h2>{product.name}</h2>
        
        <input className="completePurchase" type="text" placeholder="Cardholder Name" value={cardName} onChange={(e) => setCardName(e.target.value)}/>
        
        <br /><br />
        
        <input className="completePurchase" type="text" placeholder="Card Number" value={cardNumber} onChange={(e) => setCardNumber(e.target.value)}/>
        
        <br /><br />
        
        <input className="completePurchase" type="text" placeholder="MM/YY" value={expiration} onChange={(e) => setExpiration(e.target.value)} /> 
        
        <br /><br />
        
        <input className="completePurchase" type="text" placeholder="CVV" value={cvv} onChange={(e) => setCvv(e.target.value)}/>
        
        <br /><br />

        <button className="completePurchase" onClick={handlePurchase}>
            Complete Purchase
        </button>

        <button className="completePurchase" onClick={onBack}>
            Back
        </button>
        </>
    );
}