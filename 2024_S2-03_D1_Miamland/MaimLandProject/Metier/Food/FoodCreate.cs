 using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using IUTGame;

namespace MaimLandProject.Metier.Food
{
    public class FoodCreate 
    {
        #region attributs
        private Game game;
        /// <summary>
        /// Liste actuelle des objects Food dans le jeu
        /// </summary>
        private List<FoodItem> _foodlist = new List<FoodItem>();
        private int number;

        Random random = new Random();
        #endregion

        #region propriétés

        public List<FoodItem> foodlist
        {
            get { return _foodlist; }
            set { _foodlist = value; }
        }
        #endregion

        #region constructeur

        /// <summary>
        /// initial fabrique de aliment
        /// </summary>
        /// <param name="game"> actuelle du jeu</param>
        /// <param name="number"> nombre d'aliment par cycle</param>
        public FoodCreate(Game game, int number)
        {
            this.game = game;
            this.number = number;

            CheckAndGreate();
        }
        #endregion

        #region methodes

        /// <summary>
        /// les aliment mis à jour aprés manger,
        /// </summary>
        public void CheckAndGreate()
        {
              Random random = new Random();   
            //supprimer les aliment déjè manger
            foodlist.RemoveAll(f => f.IsEaten);

            //s'il n'y a plus d'aliment, créé nouveau
            if (foodlist.Count == 0)
            {

                for (int i = 0; i < number; i++) 
                {
                    double x = random.Next(0, (int)game.Screen.Width - 50);
                    double y = random.Next(0, (int)game.Screen.Height - 50);
                   
                    FoodItem newFood = new FoodItem(x, y, game, this);
                    bool IsSamePosition = false;

                    foreach (FoodItem f in foodlist)
                    {
                        if (newFood.IsCollide(f))
                        {
                            IsSamePosition = true;
                            break;
                        }
                    }

                    if (! IsSamePosition)
                    {
                        foodlist.Add(newFood);
                        game.AddItem(newFood);
                    }
                    else 
                    {
                        newFood.Dispose();
                        i--;
                    }

                }
                
            }
        }
        #endregion
    }
}


