using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Controls;
using System.Windows.Media.Animation;
using System.Windows.Media.TextFormatting;
using IUTGame;
using static System.Formats.Asn1.AsnWriter;
using static System.Runtime.InteropServices.JavaScript.JSType;

namespace MaimLandProject.Metier.Food
{
    public class FoodItem : GameItem
    {
        #region attributs
        /// <summary>
        /// indique si cet aliment a été mangé
        /// </summary>
        private bool isEaten;

        private FoodCreate foodManager;
        #endregion

        #region propriétés

        public bool IsEaten
        {
            get { return isEaten; }
            set { isEaten = value;}
        }
        /// <summary>
        /// nombre total d'aliment mangé
        /// </summary>
        public static int EatCount = 0 ;

        /// <summary>
        /// zone de text pour afficher le compteur de note 
        /// </summary>
        public static TextBlock ScoreText;

        /// <summary>
        /// nom de type d'objet
        /// </summary>
        public override string TypeName => "Food";

        #endregion

        #region constructeur

        /// <summary>
        /// initial Food 
        /// </summary>
        /// <param name="x"> coordonne X </param>
        /// <param name="y"> coordonne Y </param>
        /// <param name="g"> Jeu </param>
        /// <param name="foodManager"> connect avec foodCreate</param>
        public FoodItem(double x, double y, Game g, FoodCreate foodManager) :
        base(x, y, g, "food.png")
        {
            isEaten = false;
            this.Collidable = true;
            this.foodManager = foodManager;

        }
        #endregion

        #region methodes

        /// <summary>
        /// lors que il y a collision entre food et joueur  : mange l’aliment, met à jour le score et les aliments.
        /// </summary>
        /// <param name="other">l'autre objet en collision</param>
        public override void CollideEffect(GameItem other)
        {
            if (other.TypeName == "joueur" && other is Personnage joueur)
            {
                this.IsEaten = true;

                TheGame.RemoveItem(this);

                var FoodremainList = foodManager.foodlist;
                if (FoodremainList.All(f => f.IsEaten))
                {
                    foodManager.CheckAndGreate();
                }

                FoodItem.EatCount++;

                if (ScoreText != null)
                {
                    ScoreText.Text = $"Count: {FoodItem.EatCount}";
                    ((LeJeu)TheGame).AddMonstreOrder();

                }
                    

                if (FoodItem.EatCount == 10)
                {
                    TheGame.Win();

                }


            }
        }
        #endregion
    }
}
